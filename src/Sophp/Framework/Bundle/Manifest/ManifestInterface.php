<?php


namespace Sophp\Framework\Bundle\Manifest;


use Sophp\Framework\Bundle\Activator\ActivatorInterface;

interface ManifestInterface {
    /**
     * @return ActivatorInterface
     */
    public function getActivator();
} 