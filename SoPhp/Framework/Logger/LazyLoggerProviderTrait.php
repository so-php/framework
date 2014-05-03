<?php


namespace SoPhp\Framework\Logger;


use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class LazyLoggerProviderTrait
 * @package SoPhp\Framework\Logger
 * @satisifies SoPhp\Framework\Logger\LoggerAwareInterface
 */
trait LazyLoggerProviderTrait {
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
     * @param Logger $logger
     */
    public function setLogger(Logger $logger){
        $this->_logger = $logger;
    }

    /**
     * @return AMQPChannel
     */
    abstract public function getChannel();
} 