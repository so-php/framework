<?php


namespace Integration\Sophp\Framework\Metadata\ServiceProviderCache;


use Sophp\Framework\Metadata\ServiceProviderCache\Adapter\Memory;
use Sophp\Framework\Metadata\ServiceProviderCache\Model\CacheEntry;
use Sophp\Framework\Metadata\ServiceProviderCache\ServiceProviderCacheInterface;

class ServiceProviderCacheTest extends \PHPUnit_Framework_TestCase {
    /** @var  ServiceProviderCacheInterface */
    protected $cache;

    public function setUp() {
        parent::setUp();

        $this->cache = new Memory();
    }

    public function testExistsReturnsTrueWhenServiceHasCacheEntries(){
        $service = uniqid();
        $this->cache->add($service, CacheEntry::build()->setPeerId(uniqid()));
        $this->assertTrue($this->cache->exists($service));
    }
    public function testExistsReturnsFalseWhenServiceHasNoCacheEntries(){
        $this->assertFalse($this->cache->exists(uniqid()));
    }
    public function testAdd(){
        $service = uniqid();
        $this->assertNull($this->cache->get($service));
        $entry = CacheEntry::build()->setPeerId(uniqid());
        $compare = array($entry);
        $this->cache->add($service, $entry);
        $this->assertEquals($compare, $this->cache->get($service));
    }

    public function testRemove(){
        $service = uniqid();
        $this->assertNull($this->cache->get($service));
        $entry = CacheEntry::build()->setPeerId(uniqid());
        $entry2 = CacheEntry::build()->setPeerId(uniqid());
        $compare = array($entry, $entry2);
        $compare2 = array($entry);
        $this->cache->add($service, $entry);
        $this->cache->add($service, $entry2);
        $this->assertEquals($compare, $this->cache->get($service));
        $this->cache->remove($service, $entry2);
        $this->assertEquals($compare2, $this->cache->get($service));
    }

    public function testGet(){
        $service = uniqid();
        $compare = array();
        for($i = 0; $i < rand(3,9); $i++){
            $entry = CacheEntry::build()->setPeerId(uniqid());
            $compare[] = $entry;
            $this->cache->add($service, $entry);
        }
        $this->assertEquals($compare, $this->cache->get($service));
    }
}
 