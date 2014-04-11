<?php


namespace Sophp\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\BundleInterface;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleStateInterface;

abstract class LifeCycleState implements LifeCycleStateInterface {
    /** the bundle has been uninstalled, it cannot move to another state */
    const STATE_UNINSTALLED = 0;
    /** The bundle has been successfully installed */
    const STATE_INSTALLED = 1;
    /** All classes the bundle needs are available. This state indicates either
     * the bundle is ready to be started or has stopped */
    const STATE_RESOLVED = 2;
    /** The bundle is being started, BundleActivator.start method will be called
     * and has not yet returned.  */
    const STATE_STARTING = 4;
    /** The bundle is being stopped. The BundleActivator.stop method has been
     * called but the stop method has not yet returned. */
    const STATE_STOPPING = 8;
    /** The bundle has been successfully activated and is running; the
     * BundleActivator.start method has been called and returned. */
    const STATE_ACTIVE = 16;

    /** @var  BundleInterface */
    protected $bundle;

    public function __construct(BundleInterface $bundle) {
        $this->setBundle($bundle);
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
        return $this;
    }

    /**
     * @return BundleInterface
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Returns the state as a string value (should match one of the const values)
     * @return string
     */
    abstract function __toString();
}