<?php


namespace Sophp\Framework\Bundle;


use Sophp\Framework\Activator\ActivatorInterface;

interface ActivatorProviderInterface {
    /**
     * Should return a singleton instance of activator
     * @return ActivatorInterface
     */
    public function getActivator();
} 