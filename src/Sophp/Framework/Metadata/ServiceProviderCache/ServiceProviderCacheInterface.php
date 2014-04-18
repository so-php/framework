<?php


namespace Sophp\Framework\Metadata\ServiceProviderCache;

use Sophp\Framework\Metadata\ServiceProviderCache\Model\CacheEntry;

interface ServiceProviderCacheInterface {
    /**
     * @param $service
     * @return bool
     */
    public function exists($service);

    /**
     * @param $service
     * @return CacheEntry[]
     */
    public function get($service);

    /**
     * CacheEntries are unique on Peer Id, if an existing entry exists for the peer
     * then the entry is replaced by this one. Otherwise this entry is added to the list
     *
     * @param $service
     * @param CacheEntry $cacheEntry
     * @return mixed
     */
    public function add($service, CacheEntry $cacheEntry);

    /**
     * Only matches on Peer Id, other attributes of empty can be unset and/or non-matching
     * @param $service
     * @param CacheEntry $cacheEntry
     */
    public function remove($service, CacheEntry $cacheEntry);
}