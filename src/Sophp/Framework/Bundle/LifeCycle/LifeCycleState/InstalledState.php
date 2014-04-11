<?php


namespace Sophp\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;

class InstalledState extends LifeCycleState {

    /**
     * Returns the state as a string value (should match one of the const values)
     * @return string
     */
    function __toString()
    {
        return self::STATE_INSTALLED;
    }

    /**
     * @throws IllegalStateException
     */
    public function resolve()
    {
        $this->getBundle()->getSystemBundle()->resolveBundle($this->getBundle());
    }

    /**
     * @throws IllegalStateException
     */
    public function start()
    {
        // resolve bundle first
        $this->resolve();
        // bundle will be in a new (resolved) state
        // forward start() call to the new state
        $this->getBundle()->getState()->start();
    }

    /**
     * @throws IllegalStateException
     */
    public function stop()
    {
        return;
    }

    /**
     * @throws IllegalStateException
     */
    public function uninstall()
    {
        $this->getBundle()->getSystemBundle()->uninstallBundle($this->getBundle());
    }
}