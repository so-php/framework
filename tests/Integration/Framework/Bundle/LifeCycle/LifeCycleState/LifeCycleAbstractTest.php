<?php


namespace Integration\Framework\Bundle\LifeCycle\LifeCycleState;

use Sophp\Framework\Bundle\Bundle;
use Sophp\Framework\Bundle\BundleInterface;
use Sophp\Framework\Bundle\System\System;
use Sophp\Framework\Bundle\System\SystemInterface;

/**
 * Class LifeCycleTest
 * @package Integration\Framework\Bundle\LifeCycle
 * Test bundle LifeCycle
 */
abstract class LifeCycleAbstractTest extends \PHPUnit_Framework_TestCase {
    /** @var  SystemInterface */
    protected $systemBundle;
    /** @var  BundleInterface */
    protected $bundle;


    public function setUp() {
        parent::setUp();

        $this->systemBundle = new System();
        $this->bundle = new Bundle($this->systemBundle);
    }

    abstract public function testResolve();
    abstract public function testStart();
    abstract public function testStop();
    abstract public function testUninstall();

}
 