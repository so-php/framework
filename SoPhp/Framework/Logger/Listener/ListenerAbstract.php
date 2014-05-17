<?php


namespace SoPhp\Framework\Logger\Listener;


use PhpAmqpLib\Channel\AMQPChannel;
use SoPhp\Framework\Logger\Logger;

abstract class ListenerAbstract {

    /** @var  AMQPChannel */
    protected $channel;
    /** @var  string */
    protected $queueName;
    /** @var  string */
    protected $consumerTag;

    public function __construct(AMQPChannel $channel){
        $this->setChannel($channel);
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param AMQPChannel $channel
     * @return self
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return string
     */
    protected function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @param string $queueName
     * @return self
     */
    protected function setQueueName($queueName)
    {
        $this->queueName = $queueName;
        return $this;
    }

    /**
     * @return string
     */
    protected function getConsumerTag()
    {
        return $this->consumerTag;
    }

    /**
     * @param string $consumerTag
     * @return self
     */
    protected function setConsumerTag($consumerTag)
    {
        $this->consumerTag = $consumerTag;
        return $this;
    }



    /**
     * Message handler
     * @param $msg
     */
    abstract public function onMessage($msg);

    /**
     * Start listening to logger messages
     */
    public function start() {
        Logger::declareExchange($this->getChannel());
        list($queue_name, ,) = $this->getChannel()->queue_declare("", false, false, true, false);
        $this->setQueueName($queue_name);
        $this->getChannel()->queue_bind($this->getQueueName(), Logger::EXCHANGE_NAME);

        $tag = $this->getChannel()->basic_consume(
            $this->getQueueName(),
            '', false, false, false, false,
            array($this, 'onMessage'));

        $this->setConsumerTag($tag);
    }

    /**
     * Stop listening to logger messages
     */
    public function stop(){
        $this->getChannel()->basic_cancel($this->getConsumerTag());
    }
} 