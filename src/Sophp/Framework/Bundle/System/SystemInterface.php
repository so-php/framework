<?php


namespace Sophp\Framework\Bundle\System;
use \Sophp\Framework\Bundle\BundleInterface;

interface SystemInterface extends BundleInterface {
    /**
     * @return self
     */
    public function init();
    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function resolveBundle(BundleInterface $bundle);

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function startBundle(BundleInterface $bundle);

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function activateBundle(BundleInterface $bundle);
    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function stopBundle(BundleInterface $bundle);

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function updateBundle(BundleInterface $bundle);

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function uninstallBundle(BundleInterface $bundle);
} 