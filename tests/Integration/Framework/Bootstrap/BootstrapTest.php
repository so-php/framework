<?php


namespace Integration\Framework\Bootstrap;


use Sophp\Framework\Bootstrap\Bootstrap;
use Sophp\Framework\Bundle\System\System;

class BootstrapTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testStartActivatesASystemBundle(){
        $bootstrap = new Bootstrap();
        $bundle = $bootstrap->getSystemBundle();
        $this->assertNull($bundle);

        $bootstrap->start();
        $bundle = $bootstrap->getSystemBundle();
        $this->assertInstanceOf(get_class(new System()), $bundle);
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ActiveState',
            $bundle->getState());
    }
}
 