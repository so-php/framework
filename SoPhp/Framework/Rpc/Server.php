<?php


namespace SoPhp\Framework\Rpc;


use PhpAmqpLib\Message\AMQPMessage;
use SoPhp\Framework\PhpAmqpLib\ChannelAwareInterface;
use SoPhp\Framework\PhpAmqpLib\ChannelAwareTrait;
use SoPhp\Framework\Rpc\Dto\Fault;
use SoPhp\Framework\Rpc\Dto\Request;
use SoPhp\Framework\Rpc\Dto\Response;
use SoPhp\Framework\ServiceLocator\ServiceLocatorAwareInterface;
use SoPhp\Framework\ServiceLocator\ServiceLocatorAwareTrait;

class Server implements ChannelAwareInterface, ServiceLocatorAwareInterface {
    use ChannelAwareTrait;
    use ServiceLocatorAwareTrait;

    /** @var bool  */
    private $initialized = false;
    /** @var  array */
    private $serviceQueues;

    protected function _init(){
        if($this->initialized){
            return;
        }

        $channel = $this->getChannel();
        Rpc::declareExchange($channel);
        $channel->basic_qos(null, 1, null);
        $this->initialized = true;
    }

    /**
     * @param  string$serviceName
     */
    public function registerService($serviceName){
        $this->_init();

        $route = Rpc::serviceNameToBindingRoute($serviceName);
        $channel = $this->getChannel();
        // use the route as the queue name as well (setting up a single queue per service)
        $channel->queue_declare($route, false, true, false, false);
        $channel->queue_bind($route, Rpc::EXCHANGE_NAME, $route);
        $channel->basic_consume($route, '', false, false, false, false, array($this, 'onRpcRequest'));

        $this->serviceQueues[$serviceName] = $route;
    }

    public function unregisterService($serviceName){
        // TODO
    }

    /**
     * @param AMQPMessage $request
     */
    public function onRpcRequest(AMQPMessage $request){
        echo ' [x] received ['.$request->delivery_info['routing_key'].']:', $request->body, "\n";

        try {
            $rpcRequest = unserialize($request->body);
            if(!$rpcRequest instanceof Request) {
                throw new \RuntimeException("Request was not a serialized Request Dto");
            }
            $locator = $this->getServiceLocator();
            if(!$locator){
                throw new \RuntimeException("Service Locator was not provided");
            }
            $rpInstance = $locator->get($rpcRequest->getClass());
            if(!is_callable(array($rpInstance, $rpcRequest->getMethod()))){
                throw new \RuntimeException("Method `{$rpcRequest->getMethod()}` was not callable on service `{$rpcRequest->getClass()}`");
            }
            $value = call_user_func_array(array($rpInstance, $rpcRequest->getMethod()), $rpcRequest->getParams());
            $response = new Response($value);
        } catch (\Exception $e) {
            $response = new Response(Fault::factory($e), true);
        }

        $msg = new AMQPMessage(
            serialize($response),
            array('correlation_id' => $request->get('correlation_id'))
        );

        $request->delivery_info['channel']->basic_publish($msg, '', $request->get('reply_to'));
        $request->delivery_info['channel']->basic_ack($request->delivery_info['delivery_tag']);
    }
} 