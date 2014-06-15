<?php


namespace SoPhp\Framework\Activator;

use SoPhp\Framework\Logger\Listener\Console;
use SoPhp\Framework\Logger\Listener\ListenerAbstract;
use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\Loader\Loader;
use SoPhp\ServiceRegistry\ServiceRegistry;
use SoPhp\ServiceRegistry\ServiceRegistryAwareInterface;
use SoPhp\ServiceRegistry\Storage\Mongo\Mongo;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;


class Activator implements ActivatorInterface {
    /** @var  Loader */
    protected $loader;
    /** @var  ListenerAbstract */
    protected $logListener;

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
        $logger->info("Starting Bundles ...");

        $this->initLogger($context);

        $this->initServiceLocator($context);

        $this->initServiceRegistry($context);

        $this->startBundles($context);

        $logger->info("Started Bundles. ");
    }

    /**
     * @param Context $context
     */
    public function stop(Context $context)
    {
        $logger = $context->getLogger();
        $logger->info("Stopping Bundles ...");

        $this->stopBundles($context);

        $logger->info("Stopped Bundles.");
    }

    /**
     * @param Context $context
     */
    protected function initServiceLocator(Context $context)
    {
        $framework = $context->getFramework();
        $manager = new ServiceManager();
        $manager->setAllowOverride(true);
        $manager->setShareByDefault(false);

        $configArray = $framework->getConfig();
        $config = new Config(@$configArray['service_manager'] ?: array());
        $config->configureServiceManager($manager);

        $framework->setServiceLocator($manager);

        $context->setServiceLocator($manager);
    }

    /**
     * @param Context $context
     */
    protected function initServiceRegistry(Context $context)
    {
        $framework = $context->getFramework();
        if($framework instanceof ServiceRegistryAwareInterface) {
            // TODO configure storage from config
            $serviceRegistry = new ServiceRegistry($context->getChannel(), new Mongo());
            $framework->setServiceRegistry($serviceRegistry);
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

    /**
     * @param Context $context
     */
    protected function initLogger(Context $context)
    {
        $listener = new Console($context->getChannel());
        $listener->start();
    }


}