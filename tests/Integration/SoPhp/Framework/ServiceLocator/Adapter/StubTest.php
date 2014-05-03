<?php


namespace Integration\SoPhp\Framework\ServiceLocator\Adapter;


use Integration\SoPhp\Framework\ServiceLocator\AbstractServiceLocatorTest;
use PHPUnit_Framework_MockObject_MockObject;
use SoPhp\Framework\ServiceLocator\Adapter\Stub;
use SoPhp\Framework\ServiceLocator\ServiceLocatorInterface;

/**
 * Class StubTest
 * @package Integration\SoPhp\Framework\ServiceLocator\Adapter
 * @group ServiceLocator
 */
class StubTest extends AbstractServiceLocatorTest {

    public function setUp() {
        parent::setUp();
    }

    /**
     * @return ServiceLocatorInterface $locator
     */
    protected function getAdapter()
    {
        return new Stub();
    }

    /**
     * @param array $methods
     * @param bool $callConstructor
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAdapterMock($methods = array(), $callConstructor = true)
    {
        return $this->getMock('\SoPhp\Framework\ServiceLocator\Adapter\Stub', $methods, array(), '', $callConstructor);
    }


}
 