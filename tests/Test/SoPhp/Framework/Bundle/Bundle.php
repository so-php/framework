<?php


namespace Test\SoPhp\Framework\Bundle;


use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\BundleInterface;

class Bundle implements BundleInterface {
    /** @var  Context */
    protected $context;


    /**
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }
}