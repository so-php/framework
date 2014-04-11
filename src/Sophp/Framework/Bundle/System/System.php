<?php


namespace Sophp\Framework\Bundle\System;


use Sophp\Framework\Bundle\Bundle;
use Sophp\Framework\Bundle\BundleInterface;
use Sophp\Framework\Bundle\Exception\BundleException;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ActiveState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ResolvedState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\StartingState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\StoppingState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\UninstalledState;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleStateInterface;
use Sophp\Framework\Bundle\System\Listener\SystemListenerInterface;
use Zend\EventManager\EventManager;

class System extends Bundle implements SystemInterface {
    /** @var  EventManager */
    protected $systemEventManager;
    /** @var  EventManager */
    protected $bundleEventManager;
    /** @var   */
    protected $bundles;

    function __construct()
    {
        parent::__construct($this);

        $this->systemEventManager = new EventManager();
        $this->bundleEventManager = new EventManager();
    }


    public function getSystemBundle()
    {
        return $this;
    }


    public function init(){

        $this->resolve();

        $state = new StartingState($this);
        $this->setStateAndNotify($this, $state);
        return $this;
    }

    public function start()
    {
        $state = new ActiveState($this);
        $this->setStateAndNotify($this, $state);
        // $this->fireSystemBundleEvent(STARTED, $this);
    }

    public function stop()
    {
        parent::stop();
        // $this->fireSystemBundleEvent(STOPPED, $this);
    }

    public function update()
    {
        parent::update();
        // $this->fireSystemBundleEvent(UPDATED, $this);
    }

    public function uninstall()
    {
        throw new BundleException("Cannot uninstall the system bundle.");
    }


    /**
     * @param BundleInterface $bundle
     * @throws IllegalStateException
     * @return self
     */
    public function startBundle(BundleInterface $bundle)
    {
        // TODO validate state
        //      create context
        $state = new StartingState($bundle);
        $this->setStateAndNotify($bundle, $state);
        $this->activateBundle($bundle);
        //$this->fireBundleEvent(Event::STARTED, $bundle);
        //$this->fireSystemEvent(Event::STARTED, $this);
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function activateBundle(BundleInterface $bundle)
    {
        //$this->fireBundleEvent(STARTING, $bundle);
        // setBundleActivator(createBundleActivator(bundle))
        // call activator.start
        $state = new ActiveState($bundle);
        $this->setStateAndNotify($bundle, $state);
        //$this->setStateAndNotify($bundle, $bundle->getState()->activate());
        // $this->fireBundleEvent(STARTED, bundle)
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function stopBundle(BundleInterface $bundle)
    {
        // TODO: Implement stopBundle() method.
        $state = new StoppingState($bundle);
        $this->setStateAndNotify($bundle, $state);
        // call activator(s).stop
        // unset bundle context
        $state = new ResolvedState($bundle);
        $this->setStateAndNotify($bundle, $state);
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function updateBundle(BundleInterface $bundle)
    {
        $oldState = $bundle->getState();
        $this->stopBundle($bundle);

        // TODO: Implement updateBundle() method.

        // restart bundle if it was started when we updated it
        if(is_subclass_of($oldState, '\Sophp\Framework\Bundle\LifeCycle\LifeCycleState\ActiveState')){
            $this->startBundle($bundle);
        }
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function uninstallBundle(BundleInterface $bundle)
    {
        // TODO: Implement uninstallBundle() method.
        $state = new UninstalledState($bundle);
        $this->setStateAndNotify($bundle, $state);
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function resolveBundle(BundleInterface $bundle)
    {
        // TODO

        $state = new ResolvedState($bundle);
        $this->setStateAndNotify($bundle, $state);
    }

    /**
     * @param BundleInterface $bundle
     * @param LifeCycleStateInterface $state
     */
    protected function setStateAndNotify(BundleInterface $bundle, LifeCycleStateInterface $state)
    {
        $bundle->setState($state);
        // TODO notify observers
    }

    /**
     * @param SystemListenerInterface $listener
     * @return mixed|\Zend\Stdlib\CallbackHandler
     */
    public function addSystemListener(SystemListenerInterface $listener) {
        return $this->systemEventManager->attach(
            $listener->getEvent(),
            $listener->getCallback(),
            $listener->getPriority());
    }

    /**
     * @param SystemListenerInterface $listener
     * @return mixed|\Zend\Stdlib\CallbackHandler
     */
    public function addBundleListener(SystemListenerInterface $listener) {
        return $this->systemEventManager->attach(
            $listener->getEvent(),
            $listener->getCallback(),
            $listener->getPriority());
    }

    /**
     * @param $event
     * @param $bundle
     */
    protected function fireBundleEvent($event, $bundle)
    {
        // TODO
    }

    /**
     * @param $event
     */
    protected function fireSystemEvent($event){
        // TODO
    }


}