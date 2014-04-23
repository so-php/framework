<?php


namespace Sophp\Framework\ServiceManager\AbstractFactory;


use Sophp\Framework\EventManager\RemoteEventManager;
use Sophp\Framework\Metadata\Metadata;
use Sophp\Framework\Metadata\ServiceProviderCache\Model\CacheEntry;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * TODO
 * Class PeeringServiceFactory
 * @package Sophp\Framework\ServiceManager\AbstractFactory
 */
class PeeringServiceFactory implements AbstractFactoryInterface {
    const CAN_CREATE_SERVICE_WITH_NAME_EVENT = 'peeringServiceFactory.canCreateServiceWithNameEvent';

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
        /** @var Metadata $metadata */
        $metadata = $serviceLocator->get('\Sophp\Framework\Metadata\Metadata');
        if(!$metadata->getServiceProviderCache()->exists($requestedName)) {
            // curl multi-request to all peers to check if any can provide requestedName
            /** @var RemoteEventManager $remoteEventManager */
            $remoteEventManager = $serviceLocator->get('\Sophp\Framework\EventManager\RemoteEventManager');
            $remoteEventManager->trigger(self::CAN_CREATE_SERVICE_WITH_NAME_EVENT, $requestedName);
        }

        $entries = $metadata->getServiceProviderCache()->get($requestedName);
        foreach($entries as $entry){
            /** @var CacheEntry $entry */
            if($entry->getCanProvide()){
                return true;
            }
        }
        return false;
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