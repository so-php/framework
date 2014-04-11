<?php


namespace Sophp\Framework\Bundle\Context;


use Sophp\Framework\Bundle\BundleInterface;
use Sophp\Framework\Bundle\System\System;
use Sophp\Framework\Bundle\System\SystemInterface;

class Context implements ContextInterface {
    /** @var  BundleInterface */
    protected $bundle;
    /** @var  SystemInterface */
    protected $systemBundle;

    function __construct(BundleInterface $bundle)
    {
        $this->bundle = $bundle;
    }


    /**
     * @param BundleInterface $bundle
     * @return self
     */
    protected function setBundle($bundle)
    {
        $this->bundle = $bundle;
        return $this;
    }

    /**
     * @return BundleInterface
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @return System
     */
    public function getSystemBundle()
    {
        return $this->systemBundle;
    }

    /**
     * @param System $bundle
     * @return self
     */
    public function setSystemBundle(System $bundle)
    {
        $this->systemBundle = $bundle;
        return $this;
    }
}