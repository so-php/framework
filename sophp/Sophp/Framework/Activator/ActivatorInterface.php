<?php


namespace Sophp\Framework\Activator;

use Sophp\Framework\Activator\Context\Context;

interface ActivatorInterface {
    /**
     * @param Context $context
     */
    public function start(Context $context);

    /**
     * @param Context $context
     */
    public function stop(Context $context);
}