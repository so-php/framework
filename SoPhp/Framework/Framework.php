<?php


namespace SoPhp\Framework;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use SoPhp\Framework\Activator\Activator;
use SoPhp\Framework\Activator\ActivatorInterface;
use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\ActivatorProviderInterface;
use SoPhp\Framework\Bundle\AutoloaderProviderInterface;
use SoPhp\Framework\Bundle\BundleInterface;
use SoPhp\Framework\Logger\Logger;

class Framework implements FrameworkInterface, BundleInterface {
    /** @var  ActivatorInterface */
    protected $activator;

    /**
     * @var BundleInterface[]
     */
    protected $bundles=array();

    /**
     * @var AMQPConnection
     */
    protected $connection;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @return AMQPConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param AMQPConnection $connection
     * @return self
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param AMQPChannel $channel
     * @return self
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        // TODO use service locator or DI
        if(!$this->logger) {
            $this->logger = new Logger($this->getChannel());
        }
        return $this->logger;
    }


    /**
     * @param AMQPConnection $connection
     */
    public function __construct(AMQPConnection $connection){
        $this->setConnection($connection);
    }

    /**
     *
     */
    protected function init(){
        // get public channel
        $this->setChannel($this->getConnection()->channel());

        $this->activator = new Activator();
        $this->activator->start(new Context($this, $this));
    }

    /**
     * @throws \PhpAmqpLib\Exception\AMQPOutOfBoundsException
     * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
     */
    public function run(){
        $this->init();

        $this->getLogger()->info(" [*] Running. To exit press CTRL+C");

        // todo add stop condition
        while(count($this->channel->callbacks) > 0) {
            $this->channel->wait();
        }

        $this->activator->stop($this->getContext());
    }


    /**
     * @return BundleInterface[]
     */
    public function getBundles()
    {
        return $this->bundles;
    }

    /**
     * @param BundleInterface $bundle
     */
    public function load(BundleInterface $bundle)
    {
        // process config stuffs & autoloaders
        if($bundle instanceof AutoloaderProviderInterface){
            $bundle->getAutoloader();
        }

        $this->bundles[] = $bundle;
    }

    /**
     * @param BundleInterface $bundle
     */
    public function start(BundleInterface $bundle)
    {
        if($bundle instanceof ActivatorProviderInterface){
            $activator = $bundle->getActivator();
            /** @var $bundle BundleInterface */
            $activator->start(new Context($bundle, $this));
        }
    }

    /**
     * @param BundleInterface $bundle
     */
    public function stop(BundleInterface $bundle)
    {
        if($bundle instanceof ActivatorProviderInterface){
            $activator = $bundle->getActivator();
            /** @var $bundle BundleInterface */
            $activator->stop($bundle->getContext());
        }
    }

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