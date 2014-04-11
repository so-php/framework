<?php


namespace Sophp\Framework\Bundle;


use Sophp\Framework\Bundle\Context\ContextInterface;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\InstalledState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\LifeCycleState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleStateInterface;
use Sophp\Framework\Bundle\System\System;
use Sophp\Framework\Bundle\System\SystemInterface;

class Bundle implements BundleInterface {
    /** @var  string */
    protected $symbolicName;
    /** @var  System */
    protected $systemBundle;
    /** @var  ContextInterface */
    protected $bundleContext;
    /** @var  LifeCycleState */
    protected $state;

    function __construct(SystemInterface $systemBundle)
    {
        $this->setSystemBundle($systemBundle);
        $this->setState(new InstalledState($this));
    }

    public function resolve()
    {
        $this->getState()->resolve();
    }

    public function start()
    {
        $this->getState()->start();
    }

    public function stop()
    {
        $this->getState()->stop();
    }

    public function update()
    {
        $this->getState()->update();
    }

    public function uninstall()
    {
        $this->getState()->uninstall();
    }

    /**
     * @return ContextInterface
     */
    public function getBundleContext()
    {
        return $this->bundleContext;
    }

    /**
     * @return SystemInterface
     */
    public function getSystemBundle()
    {
        return $this->systemBundle;
    }

    /**
     * @param SystemInterface $bundle
     * @return self
     */
    public function setSystemBundle(SystemInterface $bundle)
    {
        $this->systemBundle = $bundle;
    }

    /**
     * @param ContextInterface $context
     * @return self
     */
    function setBundleContext(ContextInterface $context)
    {
        $this->bundleContext = $context;
    }

    /**
     * Used internally
     * @param LifeCycleStateInterface $state
     * @return self
     */
    public function setState(LifeCycleStateInterface $state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return LifeCycleState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getSymbolicName()
    {
        return $this->symbolicName;
    }

    /**
     * @param string $symbolicName
     * @return self
     */
    public function setSymbolicName($symbolicName)
    {
        $this->symbolicName = $symbolicName;
        return $this;
    }

    /**
     * Test if current state is in expected state
     * @param int $stateMask
     */
    protected function inExpectedState($stateMask){

    }
}