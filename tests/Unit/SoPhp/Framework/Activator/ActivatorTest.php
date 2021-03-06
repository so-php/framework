<?php


namespace Unit\SoPhp\Framework\Activator;


use PHPUnit_Framework_MockObject_MockObject;
use SoPhp\Framework\Activator\Activator;
use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\BundleInterface;
use SoPhp\Framework\Bundle\Loader\Loader;
use SoPhp\Framework\FrameworkInterface;
use SoPhp\Framework\Logger\Logger;

class ActivatorTest extends \PHPUnit_Framework_TestCase {
    /** @var  Activator */
    protected $activator;

    public function setUp() {
        parent::setUp();

        $this->activator = new Activator();
    }

    protected function getContextWithMocks(){
        $loggerMock = $this->getMock('\SoPhp\Framework\Logger\Logger', array(), array(), '', false);
        $frameworkMock = $this->getMock('\SoPhp\Framework\FrameworkInterface');
        $bundleMock = $this->getMock('\Test\SoPhp\Framework\Bundle\BundleWithActivator');

        $frameworkMock->expects($this->any())
            ->method('getConfig')
            ->will($this->returnValue(new \ArrayObject(array(
            'bundles' => array(
                'deployDir' => __DIR__,
                'searchDepth' => 0,
            ),
        ))));

        /** @var $loggerMock Logger */
        /** @var $bundleMock BundleInterface */
        /** @var $frameworkMock FrameworkInterface */
        $context = new Context( $bundleMock, $frameworkMock);
        $context->setLogger($loggerMock);
        return $context;
    }

    public function testStartLoadsAndStartsBundlesThroughFramework(){
        $context = $this->getContextWithMocks();

        /** @var PHPUnit_Framework_MockObject_MockObject $frameworkMock */
        $frameworkMock = $context->getFramework();
        $frameworkMock->expects($this->once())
            ->method('load')
            ->with($context->getBundle());
        $frameworkMock->expects($this->once())
            ->method('start')
            ->with($context->getBundle());
        $frameworkMock->expects($this->any())
            ->method('getChannel')
            ->will($this->returnValue($this->getMock('\PhpAmqpLib\Channel\AMQPChannel', array(), array(), '', false)));

        $loaderMock = $this->getMock('\SoPhp\Framework\Bundle\Loader\Loader');
        $loaderMock->expects($this->once())
            ->method('load')
            ->will($this->returnValue(array($context->getBundle())));
        /** @var $loaderMock Loader */
        $this->activator->setLoader($loaderMock);

        $this->activator->start($context);
    }

    public function testStopStopsBundlesThroughFramework(){
        $context = $this->getContextWithMocks();

        /** @var PHPUnit_Framework_MockObject_MockObject $frameworkMock */
        $frameworkMock = $context->getFramework();
        $frameworkMock->expects($this->once())
            ->method('stop')
            ->with($context->getBundle());
        $frameworkMock->expects($this->once())
            ->method('getBundles')
            ->will($this->returnValue(array($context->getBundle())));

        $this->activator->stop($context);
    }
}
 