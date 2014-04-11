<?php


namespace Sophp\Framework\Bundle\LifeCycle;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\LifeCycleState;

interface LifeCycleInterface extends LifeCycleStateInterface {
    /**
     * @param LifeCycleStateInterface $state
     * @return self
     */
    public function setState(LifeCycleStateInterface $state);
    /**
     * @return LifeCycleState
     */
    public function getState();
}