<?php


namespace SoPhp\Framework\ServiceRegistry;

/**
 * Class ServiceRegistryAwareTrait
 * @package SoPhp\Framework\ServiceRegistry
 * @satisfies ServiceRegistryAwareInterface
 */
trait ServiceRegistryAwareTrait {
    /** @var  ServiceRegistryInterface */
    private $serviceRegistry;
    /**
     * @param ServiceRegistryInterface $registry
     */
    public function setServiceRegistry(ServiceRegistryInterface $registry)
    {
        $this->serviceRegistry = $registry;
    }

    /**
     * @return ServiceRegistryInterface
     */
    public function getServiceRegistry()
    {
        return $this->serviceRegistry;
    }
}