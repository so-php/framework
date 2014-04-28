<?php


namespace SoPhp\Framework\Bundle;


use SoPhp\Framework\Activator\ActivatorInterface;

interface ActivatorProviderInterface {
    /**
     * Should return a singleton instance of activator
     * @return ActivatorInterface
     */
    public function getActivator();
} 