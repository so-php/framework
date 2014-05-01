<?php


namespace SoPhp\Framework\ServiceLocator;


interface ServiceLocatorInterface {
    /**
     * @param string $serviceName
     * @return mixed
     */
    public function get($serviceName);

    /**
     * @param string $serviceName
     * @return bool
     */
    public function canCreate($serviceName);
} 