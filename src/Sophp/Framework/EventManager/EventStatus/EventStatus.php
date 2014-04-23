<?php


namespace Sophp\Framework\EventManager\EventStatus;


class EventStatus {
    /**
     * Check if all listeners have completed
     * @return bool
     */
    public function isComplete(){}

    /**
     * blocks until the next response is received (or times out)
     */
    public function waitOne(){}

    /**
     * blocks until all response have been received (or timeout)
     */
    public function waitAll(){}

    /**
     * An array of the triggered handler response.
     * Non blocking, returns the current aggregated list, will be subject to
     * change until status is complete.
     * ResponseAggregate[]
     */
    public function response(){}
} 