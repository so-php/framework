<?php


namespace Integration\Sophp\Framework\Metadata\Storage;


use Sophp\Framework\Metadata\Storage\CacheAdapter;
use Zend\Cache\StorageFactory;

class CacheAdapterTest extends \PHPUnit_Framework_TestCase {
    /** @var  CacheAdapter */
    protected $adapter;

    public function setUp() {
        parent::setUp();

        $cache = StorageFactory::factory(array(
            'adapter' => array('name'=>'Memory'),
        ));
        $this->adapter = new CacheAdapter($cache, uniqid());
    }

    public function testAddInitializesStore(){
        $value = uniqid();
        $compare = array('foo' => $value);
        $this->adapter->add('foo', $value);
        $test = $this->adapter->getAll();
        $this->assertEquals($compare, $test);
    }

    public function testAddAppendsToStore(){
        $initial = array(uniqid() => uniqid());
        $this->adapter->getCache()->setItem($this->adapter->getKey(), $initial);
        $value = uniqid();
        $key = uniqid();
        $compare = array_merge($initial, array($key => $value));
        $this->adapter->add($key, $value);
        $test = $this->adapter->getAll();
        $this->assertEquals($compare, $test);
    }

    public function testRemove(){
        $key = uniqid();
        $initial = array($key => uniqid());
        $this->adapter->getCache()->setItem($this->adapter->getKey(), $initial);
        $this->adapter->remove($key);
        $test = $this->adapter->getAll();
        $this->assertEquals(array(), $test);
    }

    public function testRemoveOnEmptyStore(){
        $key = uniqid();
        $this->adapter->remove($key);
    }

    public function testHasForExistingKey(){
        $key = uniqid();
        $initial = array($key => uniqid());
        $this->adapter->getCache()->setItem($this->adapter->getKey(), $initial);
        $test = $this->adapter->has($key);
        $this->assertTrue($test);
    }

    public function testHasForNonExistingKey(){
        $key = uniqid();
        $test = $this->adapter->has($key);
        $this->assertFalse($test);
    }

    public function testGetAllReturnsStore(){
        $initial = array(uniqid() => uniqid(), uniqid() => uniqid(), uniqid() => uniqid());
        $this->adapter->getCache()->setItem($this->adapter->getKey(), $initial);
        $test = $this->adapter->getAll();
        $this->assertEquals($initial, $test);
    }

    // TODO figure out how to prove checkAndSet loop is valid for Add & Remove
}
 