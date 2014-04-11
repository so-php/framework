<?php


namespace Unit\Framework\Bootstrap;

use Sophp\Framework\Bootstrap\Bootstrap;

class BootstrapTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testStartProvidesActiveSystemBundle(){
        $bootstrap = new Bootstrap();
        $bootstrap->start();
        $this->assertInstanceOf('\Sophp\Framework\Bundle\System\System', $bootstrap->getSystemBundle());
        $this->assertInstanceOf('\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ActiveState', $bootstrap->getSystemBundle()->getState());
    }


}
 