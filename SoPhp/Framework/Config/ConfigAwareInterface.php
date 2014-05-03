<?php


namespace SoPhp\Framework\Config;


use ArrayAccess;

/**
 * Interface ConfigAwareInterface
 * @package SoPhp\Framework\Config
 */
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