<?php


namespace Test\SoPhp\Framework\Bundle;


use SoPhp\Framework\Activator\ActivatorInterface;
use SoPhp\Framework\Bundle\ActivatorProviderInterface;

class BundleWithActivator extends Bundle implements ActivatorProviderInterface {

    /**
     * Should return a singleton instance of activator
     * @return ActivatorInterface
     */
    public function getActivator()
    {

    }
}