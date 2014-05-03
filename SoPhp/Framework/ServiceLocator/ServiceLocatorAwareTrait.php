<?php


namespace SoPhp\Framework\ServiceLocator;


/**
 * Trait ServiceLocatorAwareTrait
 * @package SoPhp\Framework\ServiceLocator
 * @satisfies SoPhp\Framework\ServiceLocator\ServiceLocatorInterface
 */
trait ServiceLocatorAwareTrait {
    /** @var  ServiceLocatorInterface */
    protected $serviceLocator;

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }


} 