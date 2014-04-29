<?php


namespace Unit\SoPhp\Framework;


use PHPUnit_Framework_MockObject_MockObject;
use SoPhp\Framework\Framework;

class FrameworkTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Framework
     */
    protected $framework;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $connectionMock;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $channelMock;

    public function setUp() {
        parent::setUp();
        $this->connectionMock = $this->getMock('\Test\PhpAmqpLib\ConnectionStub');
        $this->channelMock = $this->getMock('\Test\PhpAmqpLib\ChannelStub');
        $this->connectionMock->expects($this->any())
            ->method('channel')
            ->will($this->returnValue($this->channelMock));

        $this->framework = new Framework($this->connectionMock);
    }

    public function testRunLoopsWhileChannelHasCallbacks(){
        $this->channelMock->callbacks = range(1, 5);
        $callbacks = &$this->channelMock->callbacks;

        $this->channelMock->expects($this->exactly(5))
            ->method('wait')
            ->will($this->returnCallback(function() use (&$callbacks) {
                array_pop($callbacks);
            }));

        $this->framework->run();
    }

    public function testLoadExecutesGetAutoloaderOnBundleIfAutoloaderProvider(){
        $autoloaderMock = (object)null;
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\BundleWithAutoloader');
        $bundleMock->expects($this->once())
            ->method('getAutoloader')
            ->will($this->returnValue($autoloaderMock));

        $this->framework->load($bundleMock);
    }

    public function testLoadDoesNotAttemptToExecuteLoadIfNotAutoloaderProvider(){
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\Bundle');
        $bundleMock->expects($this->never())
            ->method('getAutoloader');

        $this->framework->load($bundleMock);
    }

    public function testStartExecutesStartOnBundleActivatorIfActivatorProvider(){
        $activatorMock = $this->getMock('\SoPhp\Framework\Activator\ActivatorInterface');
        $activatorMock->expects($this->once())
            ->method('start')
            ->with($this->isInstanceOf('\SoPhp\Framework\Activator\Context\Context'));
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\BundleWithActivator');
        $bundleMock->expects($this->once())
            ->method('getActivator')
            ->will($this->returnValue($activatorMock));

        $this->framework->start($bundleMock);
    }

    public function testStartDoesNotAttemptToExecuteStartOnBundleActivatorIfNotActivatorProvider(){
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\Bundle');
        $bundleMock->expects($this->never())
            ->method('getActivator');

        $this->framework->start($bundleMock);
    }

    public function testStopExecutesStopOnBundleActivatorIfActivatorProvider(){
        $contextMock = $this->getMock('\SoPhp\Framework\Activator\Context\Context', array(), array(), '', false);
        $activatorMock = $this->getMock('\SoPhp\Framework\Activator\ActivatorInterface');
        $activatorMock->expects($this->once())
            ->method('stop')
            ->with($contextMock);
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\BundleWithActivator');
        $bundleMock->expects($this->once())
            ->method('getActivator')
            ->will($this->returnValue($activatorMock));
        $bundleMock->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($contextMock));


        $this->framework->stop($bundleMock);
    }

    public function testStopDoesNotAttemptToExecuteStopOnBundleActivatorIfNotActivatorProvider(){
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\Bundle');
        $bundleMock->expects($this->never())
            ->method('getActivator');

        $this->framework->stop($bundleMock);
    }

    public function testGetLoggerLazyLoadsInstance(){
        $channelMock = $this->getMock('\Test\PhpAmqpLib\ChannelStub');
        $this->framework->setChannel($channelMock);
        $test = $this->framework->getLogger();
        $this->assertInstanceOf('\SoPhp\Framework\Logger\Logger', $test);
    }
}
 