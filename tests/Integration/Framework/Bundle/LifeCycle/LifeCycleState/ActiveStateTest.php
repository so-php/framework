<?php


namespace Integration\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ActiveState;

class ActiveStateTest extends LifeCycleAbstractTest {

    public function setUp() {
        parent::setUp();
        $this->bundle->setState(new ActiveState($this->bundle));
    }

    /**
     * @expectedException \Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException
     */
    public function testResolve()
    {
        $this->bundle->resolve();
    }

    /**
     * @expectedException \Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException
     */
    public function testStart()
    {
        $this->bundle->start();
    }

    public function testStop()
    {
        $this->bundle->stop();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ResolvedState', $this->bundle->getState());
    }

    public function testUninstall()
    {
        $this->bundle->uninstall();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\UninstalledState', $this->bundle->getState());
    }


}
 