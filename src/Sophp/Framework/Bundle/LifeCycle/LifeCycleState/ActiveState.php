<?php


namespace Sophp\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleStateInterface;

class ActiveState extends LifeCycleState {

    /**
     * Returns the state as a string value (should match one of the const values)
     * @return string
     */
    function __toString()
    {
        return self::STATE_ACTIVE;
    }

    /**
     * @return LifeCycleStateInterface
     * @throws IllegalStateException
     */
    public function resolve()
    {
        throw new IllegalStateException("Unable to resolve bundle because it is already started.");
    }

    /**
     * @return LifeCycleStateInterface
     * @throws IllegalStateException
     */
    public function start()
    {
        throw new IllegalStateException("Unable to start bundle because it is already started.");
    }

    /**
     * @return LifeCycleStateInterface
     * @throws IllegalStateException
     */
    public function stop()
    {
        $this->getBundle()->getSystemBundle()->stopBundle($this->getBundle());
    }

    /**
     * @return LifeCycleStateInterface
     * @throws IllegalStateException
     */
    public function uninstall()
    {
        $this->getBundle()->getSystemBundle()->uninstallBundle($this->getBundle());
    }
}