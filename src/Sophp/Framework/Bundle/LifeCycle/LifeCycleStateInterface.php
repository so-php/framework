<?php


namespace Sophp\Framework\Bundle\LifeCycle;


use Sophp\Framework\Bundle\LifeCycle\LifeCycleState\Exception\IllegalStateException;

/**
 * The concrete that implements these methods are responsible for either throwing
 * and exception if the current state does not allow the transition, or forwarding
 * to the appropriate system bundle <resolve|start|stop|uninstall>Bundle method.
 *
 * Interface LifeCycleStateInterface
 * @package Sophp\Framework\Bundle\LifeCycle
 */
interface LifeCycleStateInterface {
    /**
     * @throws IllegalStateException
     */
    public function resolve();

    /**
     * @throws IllegalStateException
     */
    public function start();

    /**
     * @throws IllegalStateException
     */
    public function stop();

    /**
     * @throws IllegalStateException
     */
    public function uninstall();
} 