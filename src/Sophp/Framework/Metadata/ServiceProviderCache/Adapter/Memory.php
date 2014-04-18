<?php


namespace Sophp\Framework\Metadata\ServiceProviderCache\Adapter;


use Sophp\Framework\Metadata\ServiceProviderCache\Model\CacheEntry;
use Sophp\Framework\Metadata\ServiceProviderCache\ServiceProviderCacheInterface;

/**
 * Class Memory
 * @package Sophp\Framework\Metadata\ServiceProviderCache\Adapter
 * A memory based adapter for peer registry storage -- should only be used for
 * (unit/integration)testing.
 */
class Memory implements ServiceProviderCacheInterface {
    protected $cache = array();
    /**
     * @param $service
     * @return bool
     */
    public function exists($service)
    {
        if(isset($this->cache[$service])){
            return true;
        }
        return false;
    }

    /**
     * @param $service
     * @return CacheEntry[]
     */
    public function get($service)
    {
        return @$this->cache[$service];
    }

    /**
     * CacheEntries are unique on Peer Id, if an existing entry exists for the peer
     * then the entry is replaced by this one. Otherwise this entry is added to the list
     *
     * @param $service
     * @param CacheEntry $cacheEntry
     * @return mixed
     */
    public function add($service, CacheEntry $cacheEntry)
    {
        if(!isset($this->cache[$service])){
            $this->cache[$service] = array();
        }

        foreach($this->cache[$service] as &$entry){
            /** @var $entry CacheEntry */
            if($entry->getPeerId() === $cacheEntry->getPeerId()){
                $entry->setCanProvide($cacheEntry->getCanProvide());
                return;
            }
        }

        $this->cache[$service][] = $cacheEntry;
    }

    /**
     * Only matches on Peer Id, other attributes of empty can be unset and/or non-matching
     * @param $service
     * @param CacheEntry $cacheEntry
     */
    public function remove($service, CacheEntry $cacheEntry)
    {
        if(!isset($this->cache[$service])){
            return;
        }
        foreach($this->cache[$service] as $key => $entry){
            /** @var $entry CacheEntry */
            if($entry->getPeerId() === $cacheEntry->getPeerId()){
                unset($this->cache[$service][$key]);
                return;
            }
        }
    }
}