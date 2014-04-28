<?php


namespace Sophp\Framework\ServiceDiscovery;


interface ServiceDiscoveryInterface {
    /**
     * @param string $service
     * @param int $timeout
     * @return bool
     */
    public function canCreateService($service, $timeout = 0);
} 