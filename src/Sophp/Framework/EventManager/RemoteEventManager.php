<?php


namespace Sophp\Framework\EventManager;


use Zend\EventManager\EventManager;

/**
 * TODO
 * Class RemoteEventManager
 * @package Sophp\Framework\EventManager
 */
class RemoteEventManager extends EventManager {
    // used to specify if we should wait for all, 1 or none of peer listeners to respond
    const TRIGGER_ASYNC = 0;
    const TRIGGER_BLOCKING_ONE = 1;
    const TRIGGER_BLOCKING_ALL = 2;
} 