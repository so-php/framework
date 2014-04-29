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
}
 