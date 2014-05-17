<?php


namespace SoPhp\Framework\ServiceLocator;

/**
 * Interface ServiceLocatorAwareInterface
 * @package SoPhp\Framework\ServiceLocator
 */
interface ServiceLocatorAwareInterface {
    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator();

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator);
} 