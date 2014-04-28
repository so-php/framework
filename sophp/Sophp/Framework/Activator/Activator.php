<?php


namespace Sophp\Framework\Activator;

use PhpAmqpLib\Channel\AMQPChannel;
use Sophp\Framework\Activator\Context\Context;
use Sophp\Framework\Bundle\Loader\Loader;
use Sophp\Framework\Logger\Logger;

class Activator implements ActivatorInterface {
    /** @var  Logger */
    protected $logger;

    /**
     * @param AMQPChannel $channel
     * @return Logger
     */
    protected function getLogger(AMQPChannel $channel)
    {
        // TODO use service locator or DI
        if(!$this->logger) {
            $this->logger = new Logger($channel);
        }
        return $this->logger;
    }

    /**
     * @param Context $context
     */
    public function start(Context $context)
    {
        $logger = $this->getLogger($context->getFramework()->getChannel());
        $logger->info(" [x] Starting Bundles ...");

        $loader = new Loader();
        $bundles = $loader->load();
        // load bundles & call activator[s].start()
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
        $logger = $this->getLogger($context->getFramework()->getChannel());
        $logger->info(" [x] Stopping Bundles ...");

        foreach($context->getFramework()->getBundles() as $bundle){
            $context->getFramework()->stop($bundle);
        }

        $logger->info(" [x] Stopped Bundles.");
    }
}