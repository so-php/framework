<?php


namespace SoPhp\Framework\Config;


use ArrayAccess;

trait ConfigAware {
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