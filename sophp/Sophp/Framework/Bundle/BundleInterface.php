<?php


namespace Sophp\Framework\Bundle;


use Sophp\Framework\Activator\Context\Context;

interface BundleInterface {
    /**
     * @param Context $context
     */
    public function setContext(Context $context);

    /**
     * @return Context
     */
    public function getContext();
} 