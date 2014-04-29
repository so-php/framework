<?php


namespace SoPhp\Framework\Activator;

use PhpAmqpLib\Channel\AMQPChannel;
use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\Loader\Loader;
use SoPhp\Framework\Logger\Logger;

class Activator implements ActivatorInterface {
    /** @var  Loader */
    protected $loader;

    /**
     * @return Loader
     */
    public function getLoader()
    {
        if(!$this->loader){
            $this->loader = new Loader();
        }
        return $this->loader;
    }

    /**
     * @param Loader $loader
     * @return self
     */
    public function setLoader($loader)
    {
        $this->loader = $loader;
        return $this;
    }

    /**
     * @param Context $context
     */
    public function start(Context $context)
    {
        $logger = $context->getLogger();
        $logger->info(" [x] Starting Bundles ...");

        $loader = $this->getLoader();
        $bundles = $loader->load();

        foreach($bundles as $bundle){
            $context->getFramework()->load($bundle);
            $context->getFramework()->start($bundle);
        }

        $logger->info(" [x] Started Bundles. ");
    }

    /**
     * @param Context $context
     */
    public function stop(Context $context)
    {
        $logger = $context->getLogger();
        $logger->info(" [x] Stopping Bundles ...");

        foreach($context->getFramework()->getBundles() as $bundle){
            $context->getFramework()->stop($bundle);
        }

        $logger->info(" [x] Stopped Bundles.");
    }


}