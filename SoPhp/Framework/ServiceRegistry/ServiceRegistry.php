<?php


namespace Framework\ServiceRegistry;


use SoPhp\Framework\ServiceRegistry\ServiceRegistryInterface;

class ServiceRegistry implements ServiceRegistryInterface {

    /**
     * @param string $serviceInterface
     * @param mixed $serviceConcrete
     */
    public function registerService($serviceInterface, $serviceConcrete)
    {
        // TODO: Implement registerService() method.
    }

    /**
     * @param string $serviceInterface
     * @param mixed $serviceConcrete
     */
    public function unregisterService($serviceInterface, $serviceConcrete)
    {
        // TODO: Implement unregisterService() method.
    }
}