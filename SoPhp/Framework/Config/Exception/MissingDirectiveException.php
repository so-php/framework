<?php


namespace SoPhp\Framework\Config\Exception;


use Exception;

class MissingDirectiveException extends ConfigException {
    const MESSAGE = "Missing Configuration Directive `%s`";

    /**
     * @param string $directive
     * @param Exception $previous
     */
    function __construct($directive, Exception $previous = null)
    {
        $msg = sprintf(self::MESSAGE, $directive);
        parent::__construct($msg, 0, $previous);
    }

} 