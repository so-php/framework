<?php


namespace Unit\SoPhp\Framework\Logger;


use Test\SoPhp\Framework\Logger\LazyLogger;

class LazyLoggerProviderTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetLoggerLazyLoadsInstance(){
        $lazyLogger = new LazyLogger();
        $lazyLogger->setChannel($this->getMock('\Test\PhpAmqpLib\ChannelStub'));
        $this->assertNull($lazyLogger->getLoggerWithoutLogic());
        $test = $lazyLogger->getLogger();
        $this->assertInstanceOf('\SoPhp\Framework\Logger\Logger', $test);
        $this->assertEquals($test, $lazyLogger->getLoggerWithoutLogic());
        $this->assertEquals($test, $lazyLogger->getLogger());
    }
}
 