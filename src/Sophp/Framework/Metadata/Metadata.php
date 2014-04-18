<?php


namespace Sophp\Framework\Metadata;


use Sophp\Framework\Metadata\PeerRegistery\PeerRegistryInterface;
use Sophp\Framework\Metadata\ServiceProviderCache\ServiceProviderCacheInterface;

class Metadata {
    /** @var  PeerRegistryInterface */
    protected $peerRegistry;
    /** @var  ServiceProviderCacheInterface */
    protected $serviceProviderCache;

    /**
     * @param PeerRegistryInterface $peerRegistry
     * @return self
     */
    public function setPeerRegistry($peerRegistry)
    {
        $this->peerRegistry = $peerRegistry;
        return $this;
    }

    /**
     * @return PeerRegistryInterface
     */
    public function getPeerRegistry()
    {
        return $this->peerRegistry;
    }

    /**
     * @param ServiceProviderCacheInterface $serviceProviderCache
     * @return self
     */
    public function setServiceProviderCache($serviceProviderCache)
    {
        $this->serviceProviderCache = $serviceProviderCache;
        return $this;
    }

    /**
     * @return ServiceProviderCacheInterface
     */
    public function getServiceProviderCache()
    {
        return $this->serviceProviderCache;
    }


}