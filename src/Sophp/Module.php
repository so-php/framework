<?php


namespace Sophp;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\RouteProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * TODO
 * ZF2 tie-in
 * Class Module
 * @package Sophp
 */
class Module implements RouteProviderInterface, ServiceProviderInterface, BootstrapListenerInterface, ConfigProviderInterface {

    /**
     * Defines the entry point for RPC from peering services
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getRouteConfig()
    {
        // TODO: Implement getRouteConfig() method.
    }

    /**
     * Adds the peering service factory to the service config
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        // TODO: Implement getServiceConfig() method.
        return array(
            'service_manager' => array(
                'abstract_factories' => array(
                    '\Sophp\Framework\ServiceManager\AbstractFactory\PeeringServiceFactory'
                ),
            ),
        );
    }

    /**
     * light setup for module
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        // TODO: Implement onBootstrap() method.
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return array(
            'sophp-metatdata-cache' => array(
                // by default, this adapter will only support zf2 instances on the same server
                // it should be overridden to provide a network adapter like Redis
                'adapter' => array(
                    'name' => 'Filesystem',
                    'options' => array(
                        'namespace' => 'sophp-metadata'
                    ),
                ),
            ),
        );
    }
}