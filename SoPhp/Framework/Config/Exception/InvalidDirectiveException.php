<?php


namespace SoPhp\Framework\Config\Exception;


use Exception;

class InvalidDirectiveException extends ConfigException {
    const MESSAGE = 'Invalid Configuration Directive `%s`. %s';

    /**
     * @param string $directive
     * @param string $reason
     * @param Exception $previous
     */
    public function __construct($directive, $reason = null, Exception $previous = null) {
        $msg = sprintf(self::MESSAGE, $directive, $reason);
        parent::__construct($msg, 0, $previous);
    }
} 