<?php


namespace Sophp\Framework\Bundle;

use Sophp\Framework\Bundle\Context\ContextInterface;
use Sophp\Framework\Bundle\LifeCycle\LifeCycleInterface;
use Sophp\Framework\Bundle\System\SystemInterface;

interface BundleInterface extends LifeCycleInterface {
    /**
     * @return string
     */
    public function getSymbolicName();

    /**
     * @return SystemInterface
     */
    public function getSystemBundle();

    /**
     * @param SystemInterface $bundle
     * @return self
     */
    public function setSystemBundle(SystemInterface $bundle);

    /**
     * @return ContextInterface
     */
    public function getBundleContext();

    /**
     * @param ContextInterface $context
     * @return self
     */
    public function setBundleContext(ContextInterface $context);


} 