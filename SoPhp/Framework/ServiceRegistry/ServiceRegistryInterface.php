<?php


namespace SoPhp\Framework\ServiceRegistry;


interface ServiceRegistryInterface {
    /**
     * @param string $serviceInterface
     * @param mixed $serviceConcrete
     */
    public function registerService($serviceInterface, $serviceConcrete);

    /**
     * @param string $serviceInterface
     * @param mixed $serviceConcrete
     */
    public function unregisterService($serviceInterface, $serviceConcrete);
} 