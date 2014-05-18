<?php


namespace SoPhp\Framework\ServiceRegistry;


interface ServiceRegistryAwareInterface {
    /**
     * @param ServiceRegistryInterface $registry
     */
    public function setServiceRegistry(ServiceRegistryInterface $registry);

    /**
     * @return ServiceRegistryInterface
     */
    public function getServiceRegistry();
} 