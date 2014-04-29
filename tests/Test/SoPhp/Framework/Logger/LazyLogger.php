<?php


namespace Test\SoPhp\Framework\Logger;


use PhpAmqpLib\Channel\AMQPChannel;
use SoPhp\Framework\Logger\LazyLoggerProvider;
use SoPhp\Framework\Logger\Logger;
use Test\PhpAmqpLib\ChannelStub;

class LazyLogger {
    use LazyLoggerProvider;
    /** @var  AMQPChannel */
    protected $channel;

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
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return Logger
     */
    public function getLoggerWithoutLogic(){
        return $this->_logger;
    }
}