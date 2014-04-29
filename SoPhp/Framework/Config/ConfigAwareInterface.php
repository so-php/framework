<?php


namespace SoPhp\Framework\Config;


use ArrayAccess;

interface ConfigAwareInterface {
    /**
     * @param ArrayAccess $config
     */
    public function setConfig(ArrayAccess $config);

    /**
     * @return ArrayAccess
     */
    public function getConfig();
} 