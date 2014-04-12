<?php


namespace Sophp\Framework\ServiceManager\AbstractFactory;


use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * TODO
 * Class PeeringServiceFactory
 * @package Sophp\Framework\ServiceManager\AbstractFactory
 */
class PeeringServiceFactory implements AbstractFactoryInterface {

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        // TODO: Implement canCreateServiceWithName() method.
        // TODO: check persistent storage metadata for $name/$requestedName
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        // TODO: Implement createServiceWithName() method.
        // TODO: generate proxy service
    }
}