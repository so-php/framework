<?php


namespace Integration\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\StoppingState;

class StoppingStateTest extends LifeCycleAbstractTest {

    public function setUp() {
        parent::setUp();
        $this->bundle->setState(new StoppingState($this->bundle));
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

    /**
     * @expectedException \Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException
     */
    public function testStop()
    {
        $this->bundle->stop();
    }

    /**
     * @expectedException \Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException
     */
    public function testUninstall()
    {
        $this->bundle->uninstall();
    }

}
 