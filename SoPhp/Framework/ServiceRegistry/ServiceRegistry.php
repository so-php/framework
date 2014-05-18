<?php


namespace SoPhp\Framework\ServiceRegistry;


use SoPhp\Framework\Rpc\Server\ServerAwareInterface;
use SoPhp\Framework\Rpc\Server\ServerAwareTrait;
use SoPhp\Framework\ServiceLocator\ServiceLocatorAwareInterface;
use SoPhp\Framework\ServiceLocator\ServiceLocatorAwareTrait;

class ServiceRegistry implements ServiceRegistryInterface, ServerAwareInterface,
    ServiceLocatorAwareInterface {
    use ServerAwareTrait;
    use ServiceLocatorAwareTrait;

    /**
     * @param string $serviceInterface
     * @param mixed $serviceConcrete
     */
    public function registerService($serviceInterface, $serviceConcrete)
    {
        if(!$this->getRpcServer()){
            throw new \RuntimeException("RPCServer was not provided");
        }
        $this->getRpcServer()->registerService($serviceInterface, $serviceConcrete);
        $this->getServiceLocator()->setService($serviceInterface, $serviceConcrete);
    }

    /**
     * @param string $serviceInterface
     * @param mixed $serviceConcrete
     */
    public function unregisterService($serviceInterface, $serviceConcrete)
    {
        if(!$this->getRpcServer()){
            throw new \RuntimeException("RPCServer was not provided");
        }
        $this->getRpcServer()->unregisterService($serviceInterface, $serviceConcrete);
        $this->getServiceLocator()->unsetService($serviceInterface);
    }
}