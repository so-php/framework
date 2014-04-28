<?php


namespace Sophp\Framework\ServiceProvider;


interface ServiceProviderInterface {
    /**
     * @param string $service
     * @param int $timeout
     * @return bool
     */
    public function canProvide($service, $timeout = 0);

    /**
     * @param string $service
     * @return mixed
     */
    public function getInstance($service);
} 