<?php


namespace Integration\Framework\Bundle\LifeCycle\LifeCycleState;


class InstalledStateTest extends LifeCycleAbstractTest {
    public function setUp()
    {
        parent::setUp();
    }


    public function testResolve(){
        $this->bundle->resolve();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ResolvedState', $this->bundle->getState());
    }

    public function testStart(){
        $this->bundle->start();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ActiveState', $this->bundle->getState());
    }

    public function testStop(){
        $this->bundle->stop();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\InstalledState', $this->bundle->getState());
    }
    public function testUninstall(){
        $this->bundle->uninstall();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\UninstalledState', $this->bundle->getState());
    }
}
 