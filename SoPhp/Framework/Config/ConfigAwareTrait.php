<?php


namespace SoPhp\Framework\Config;


use ArrayAccess;

/**
 * Class ConfigAwareTrait
 * @package SoPhp\Framework\Config
 * @satisfies SoPhp\Framework\Config\ConfigAwareInterface
 */
trait ConfigAwareTrait {
    /** @var ArrayAccess */
    protected $_config;

    /**
     * @param ArrayAccess $config
     */
    public function setConfig(ArrayAccess $config){
        $this->_config = $config;
    }

    /**
     * @return ArrayAccess
     */
    public function getConfig(){
        return $this->_config;
    }
} 