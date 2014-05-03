<?php


namespace SoPhp\Framework\Logger;


interface LoggerAwareInterface {
    /**
     * @return Logger
     */
    public function getLogger();

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger);
} 