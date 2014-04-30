<?php


namespace SoPhp\Framework\Activator;

use SoPhp\Framework\ServiceLocator\ServiceLocatorAware;
use SoPhp\Framework\ServiceLocator\ServiceLocatorStub;
use PhpAmqpLib\Channel\AMQPChannel;
use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\Loader\Loader;


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

        $this->initServiceLocator($context);

        $this->startBundles($context);

        $logger->info(" [x] Started Bundles. ");
    }

    /**
     * @param Context $context
     */
    public function stop(Context $context)
    {
        $logger = $context->getLogger();
        $logger->info(" [x] Stopping Bundles ...");

        $this->stopBundles($context);

        $logger->info(" [x] Stopped Bundles.");
    }

    /**
     * @param Context $context
     */
    protected function initServiceLocator(Context $context)
    {
        $framework = $context->getFramework();
        if($framework instanceof ServiceLocatorAware) {
            $serviceLocator = new ServiceLocatorStub();
            $serviceLocator->setConfig($context->getFramework()->getConfig());
            $framework->setServiceLocator($serviceLocator);
        }
    }

    /**
     * @param Context $context
     */
    protected function startBundles(Context $context)
    {
        $framework = $context->getFramework();
        $loader = $this->getLoader();
        $loader->setConfig($framework->getConfig());

        $bundles = $loader->load();

        foreach($bundles as $bundle){
            $framework->load($bundle);
            $framework->start($bundle);
        }
    }

    /**
     * @param Context $context
     */
    protected function stopBundles(Context $context)
    {
        $framework = $context->getFramework();
        foreach($framework->getBundles() as $bundle){
            $framework->stop($bundle);
        }
    }


}