<?php


namespace Sophp\Framework\Bundle\LifeCycle\LifeCycleState;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;

class ResolvedState extends LifeCycleState {

    /**
     * Returns the state as a string value (should match one of the const values)
     * @return string
     */
    function __toString()
    {
        return self::STATE_RESOLVED;
    }

    /**
     * @throws IllegalStateException
     */
    public function resolve()
    {
        return;
    }

    /**
     * @throws IllegalStateException
     */
    public function start()
    {
        $this->getBundle()->getSystemBundle()->startBundle($this->getBundle());
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