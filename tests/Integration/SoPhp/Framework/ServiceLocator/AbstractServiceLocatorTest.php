<?php


namespace Integration\SoPhp\Framework\ServiceLocator;


use PHPUnit_Framework_MockObject_MockObject;
use ReflectionClass;
use SoPhp\Framework\ServiceLocator\ServiceLocatorInterface;
use SoPhp\Framework\ServiceLocator\ServiceLocatorPeerAwareInterface;

abstract class AbstractServiceLocatorTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    /**
     * @return ServiceLocatorInterface $locator
     */
    abstract protected function getAdapter();

    /**
     * @param array $methods
     * @param bool $callConstructor
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    abstract protected function getAdapterMock($methods = array(), $callConstructor = true);

    public function testAddPeerOnlyAddsOnce(){
        $locator = $this->getAdapter();
        if($locator instanceof ServiceLocatorPeerAwareInterface){
            $mock = $this->getAdapterMock();
            for($i = rand(2,5); $i > 0; $i--) {
                $locator->addPeer($mock);
            }
            $this->assertCount(1, $locator->getPeers());
        } else {
            $this->markTestSkipped('Test does not apply to adapter implementation');
        }
    }

    public function testAddAndRemovePeer(){
        $locator = $this->getAdapter();
        if($locator instanceof ServiceLocatorPeerAwareInterface){
            $mocks = array();
            for($i = rand(2,5); $i > 0; $i--) {
                $mock = $this->getAdapterMock();
                $locator->addPeer($mock);
                $mocks[] = $mock;
            }
            $this->assertCount(count($mocks), $locator->getPeers());
            foreach($mocks as $mock){
                $locator->remove($mock);
            }
            $this->assertCount(0, $locator->getPeers());
        } else {
            $this->markTestSkipped('Test does not apply to adapter implementation');
        }
    }

    public function testCanCreateChecksPeers(){
        $locator = $this->getAdapter();
        if($locator instanceof ServiceLocatorPeerAwareInterface){
            $serviceName = uniqid('Class');
            $peers = array();
            for($i = rand(2,5); $i>0; $i--){
                $mock = $this->getAdapterMock();
                $mock->expects($this->once())
                    ->method('canCreate')
                    ->with($serviceName, $this->isInstanceOf('\SoPhp\Framework\ServiceLocator\CyclicalResolution\CyclicalResolution'))
                    ->will($this->returnValue(false));
                $peers[] = $mock;
                $locator->addPeer($mock);
            }
            $this->invoke('canCreate', $locator, array($serviceName));
        } else {
            $this->markTestSkipped('Test does not apply to adapter implementation');
        }
    }

    public function testGetUtilizesPeer(){
        $locator = $this->getAdapter();
        if($locator instanceof ServiceLocatorPeerAwareInterface){
            $serviceName = uniqid('Class');
            $instance = (object)null;

            $mock = $this->getAdapterMock();
            $mock->expects($this->any())
                ->method('canCreate')
                ->with($serviceName, $this->isInstanceOf('\SoPhp\Framework\ServiceLocator\CyclicalResolution\CyclicalResolution'))
                ->will($this->returnValue(true));
            $mock->expects($this->once())
                ->method('get')
                ->with($serviceName)
                ->will($this->returnValue($instance));
            $locator->addPeer($mock);
            /** @var ServiceLocatorInterface $locator */
            $test = $locator->get($serviceName);
            $this->assertEquals($instance, $test);
        } else {
            $this->markTestSkipped('Test does not apply to adapter implementation');
        }
    }

    public function testSharedInstancesAreReused(){
        $locator = $this->getAdapter();
        $serviceName = 'stdClass';
        $instance = $locator->get($serviceName);
        $instance->foo = 'bar';
        for($i = rand(1,5); $i>0; $i--){
            $test = $locator->get($serviceName);
            $this->assertEquals($instance, $test);
        }
    }

    /**
     * @param $method
     * @param $object
     * @param array $args
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function invoke($method, $object, $args = array()){
        $reflectionClass = new ReflectionClass($object);
        if(!$reflectionClass->hasMethod($method)){
            $this->fail("$method does not exist on " . $reflectionClass->getName());
        }
        $reflectionMethod = $reflectionClass->getMethod($method);
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invokeArgs($object, $args);
    }
}
 