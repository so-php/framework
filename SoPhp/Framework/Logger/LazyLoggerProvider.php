<?php


namespace SoPhp\Framework\Logger;


use PhpAmqpLib\Channel\AMQPChannel;

trait LazyLoggerProvider {
    protected $_logger;
    /**
     * @return Logger
     */
    public function getLogger()
    {
        if(!$this->_logger) {
            $this->_logger = new Logger($this->getChannel());
        }
        return $this->_logger;
    }

    /**
     * @return AMQPChannel
     */
    abstract public function getChannel();
} 