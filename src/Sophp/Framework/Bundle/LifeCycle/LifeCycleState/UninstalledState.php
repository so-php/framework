<?php


namespace Sophp\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;

class UninstalledState extends LifeCycleState {

    /**
     * Returns the state as a string value (should match one of the const values)
     * @return string
     */
    function __toString()
    {
        return self::STATE_UNINSTALLED;
    }

    /**
     * @throws IllegalStateException
     */
    public function resolve()
    {
        throw new IllegalStateException("Cannot resolve bundle, it is uninstalled");
    }

    /**
     * @throws IllegalStateException
     */
    public function start()
    {
        throw new IllegalStateException("Cannot start bundle, it is uninstalled");
    }

    /**
     * @throws IllegalStateException
     */
    public function stop()
    {
        throw new IllegalStateException("Cannot stop bundle, it is uninstalled");
    }

    /**
     * @throws IllegalStateException
     */
    public function uninstall()
    {
        return;
    }
}