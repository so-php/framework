<?php


namespace SoPhp\Framework\ServiceLocator\CyclicalResolution;


use SoPhp\Framework\ServiceLocator\ServiceLocatorInterface;

class CyclicalResolution {
    /**
     * @var string
     */
    protected $references = array();

    /**
     * @param ServiceLocatorInterface $locator
     */
    public function addReference(ServiceLocatorInterface $locator){
        array_push($this->references, $locator);
    }

    /**
     * @param ServiceLocatorInterface $locator
     * @return bool
     */
    public function hasReference(ServiceLocatorInterface $locator){
        return in_array($locator->getId(), $this->references);
    }
} 