<?php


namespace Integration\Framework\Bundle\Listener;


use Zend\EventManager\ListenerAggregateInterface;

interface BundleListenerInterface {
    /**
     * @return string|array|ListenerAggregateInterface $event An event or array of event names. If a ListenerAggregateInterface, proxies to {@link attachAggregate()}.
     */
    public function getEvent();

    /**
     * @return callable|int $callback If string $event provided, expects PHP callback; for a ListenerAggregateInterface $event, this will be the priority
     */
    public function getCallback();

    /**
     * @return int $priority If provided, the priority at which to register the callable
     */
    public function getPriority();
} 