<?php


namespace SoPhp\Framework\Rpc;


use SoPhp\Framework\PhpAmqpLib\ChannelAwareInterface;
use SoPhp\Framework\PhpAmqpLib\ChannelAwareTrait;
use PhpAmqpLib\Message\AMQPMessage;
use SoPhp\Framework\Rpc\Dto\Request;
use SoPhp\Framework\Rpc\Exception\RpcFailure;

class Client implements ChannelAwareInterface {
    use ChannelAwareTrait;

    private $callback_queue;
    private $response;
    private $corr_id;
    /** @var  string */
    private $bindingRoute;
    /** @var bool  */
    private $initialized = false;
    /** @var  string fully qualified class name */
    private $serviceName;

    public function __construct($serviceName) {
        $this->setServiceName($serviceName);
        $this->setBindingRoute(Rpc::serviceNameToBindingRoute($serviceName));
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     * @return self
     */
    protected function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }



    protected function _init() {
        if($this->initialized) {
            return;
        }

        Rpc::declareExchange($this->getChannel());
        list($this->callback_queue, ,)
            = $this->getChannel()->queue_declare("", false, false, true, false);

        $this->getChannel()->basic_consume($this->callback_queue, '', false, false, false, false,
            array($this, '_onResponse'));

        $this->getChannel()->set_return_listener(array($this, '_onBasicReturn'));

    }

    public function _onResponse($rep) {
        if($rep->get('correlation_id') == $this->corr_id) {
            $this->response = unserialize($rep->body);
        }
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param string $exchange
     * @param string $routing_key
     * @param AMQPMessage $msg
     */
    public function _onBasicReturn($reply_code, $reply_text, $exchange, $routing_key, AMQPMessage $msg){
        if($msg->get('correlation_id') == $this->corr_id){
            $this->response = new RpcFailure("Message could not be routed to queue");
        }
    }

    /**
     * @return string
     */
    public function getBindingRoute()
    {
        return $this->bindingRoute;
    }

    /**
     * @param string $bindingRoute
     * @return self
     */
    protected function setBindingRoute($bindingRoute)
    {
        $this->bindingRoute = $bindingRoute;
        return $this;
    }

    /**
     * Proxy method
     * @param string $name
     * @param array $params
     * @throws \Exception
     * @return mixed
     */
    public function __call($name, $params){
        echo " [*] proxy method initiated for `$name`\n";
        $dto = new Request($this->getServiceName(), $name, $params);
        return $this->_call($dto);
    }


    /**
     * @param Request $request
     * @return null
     * @throws \Exception
     */
    protected function _call(Request $request) {
        $this->_init();

        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage(
            serialize($request),
            array('correlation_id' => $this->corr_id,
                'reply_to' => $this->callback_queue)
        );
        $this->getChannel()->basic_publish($msg, RPC::EXCHANGE_NAME, $this->getBindingRoute(), true);


        while(!$this->response) {
            $this->getChannel()->wait();
        }

        // if there was a problem executing rpc
        /*
        if($this->response instanceof \Exception){
            throw RpcFailure::generic($this->response);
        } else if(!$this->response instanceof Response) {
            throw new RpcFailure("Response was not a Response Dto");
        } else if($this->response->isIsException()){
            throw RpcFailure::generic($this->response->getRpcReturnValue());
        }
        */
        return "foo";
        return $this->response->getRpcReturnValue();
    }
} 