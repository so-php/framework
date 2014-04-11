<?php


namespace Sophp\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;

class StoppingState extends LifeCycleState {

    /**
     * Returns the state as a string value (should match one of the const values)
     * @return string
     */
    function __toString()
    {
        return self::STATE_STOPPING;
    }

    /**
     * @throws IllegalStateException
     */
    public function resolve()
    {
        throw new IllegalStateException("Cannot resolve bundle while it is stopping.");
    }

    /**
     * @throws IllegalStateException
     */
    public function start()
    {
        throw new IllegalStateException("Cannot start bundle while it is stopping.");
    }

    /**
     * @throws IllegalStateException
     */
    public function stop()
    {
        throw new IllegalStateException("Cannot resolve bundle while it is already stopping.");
    }

    /**
     * @throws IllegalStateException
     */
    public function uninstall()
    {
        throw new IllegalStateException("Cannot uninstall bundle while it is stopping.");
    }
}