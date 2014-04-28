<?php


namespace SoPhp\Framework\Bundle;


use SoPhp\Framework\Activator\Context\Context;

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