<?php


namespace Sophp\Framework\Bootstrap;


use Sophp\Framework\Bundle\System\Factory\Factory;
use Sophp\Framework\Bundle\System\SystemInterface;

/**
 * Class Bootstrap
 * @package Sophp\Framework\Bootstrap
 * Initializes the system bundle after auto-loading configuration
 */
class Bootstrap {
    /** @var  SystemInterface */
    protected $systemBundle;

    /**
     * @param SystemInterface $systemBundle
     * @return self
     */
    public function setSystemBundle(SystemInterface $systemBundle)
    {
        $this->systemBundle = $systemBundle;
        return $this;
    }

    /**
     * @return SystemInterface
     */
    public function getSystemBundle()
    {
        return $this->systemBundle;
    }

    public function start() {
        $factory = new Factory();
        // get config
        // create bundle w/ config
        $this->setSystemBundle($factory->newSystemBundle());
        $this->getSystemBundle()->init()->start();
    }
}