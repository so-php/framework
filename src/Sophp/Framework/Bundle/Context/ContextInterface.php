<?php


namespace Sophp\Framework\Bundle\Context;


use Sophp\Framework\Bundle\BundleInterface;
use Sophp\Framework\Bundle\System\System;

interface ContextInterface {
    /*
    public function addBundleListener();
    public function addFrameworkListener();
    public function addServiceListener();
    */
    /**
     * @return System
     */
    public function getSystemBundle();

    /**
     * @param System $bundle
     * @return self
     */
    public function setSystemBundle(System $bundle);

    /**
     * @return BundleInterface
     */
    public function getBundle();
} 