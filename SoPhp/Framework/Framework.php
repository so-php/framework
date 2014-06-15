<?php


namespace SoPhp\Framework;


use ArrayObject;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use SoPhp\Framework\Bundle\ConfigProviderInterface;
use SoPhp\Framework\Logger\LoggerAwareInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use SoPhp\Framework\Activator\Activator;
use SoPhp\Framework\Activator\ActivatorInterface;
use SoPhp\Framework\Activator\Context\Context;
use SoPhp\Framework\Bundle\ActivatorProviderInterface;
use SoPhp\Framework\Bundle\AutoloaderProviderInterface;
use SoPhp\Framework\Bundle\BundleInterface;
use SoPhp\Framework\Config\ConfigAwareTrait;
use SoPhp\Framework\Logger\LazyLoggerProviderTrait;
use SoPhp\ServiceRegistry\ServiceRegistryAwareInterface;
use SoPhp\ServiceRegistry\ServiceRegistryAwareTrait;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceManager;

class Framework implements FrameworkInterface, BundleInterface,
    LoggerAwareInterface, ServiceRegistryAwareInterface,
    ServiceLocatorAwareInterface {
    use ServiceLocatorAwareTrait;
    use LazyLoggerProviderTrait;
    use ConfigAwareTrait;
    use ServiceRegistryAwareTrait;

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
        $this->context = new Context($this, $this);
        $this->activator->start($this->context);
    }

    /**
     * @throws \PhpAmqpLib\Exception\AMQPOutOfBoundsException
     * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
     */
    public function run(){
        $this->init();

        $this->getLogger()->info("Running. To exit press CTRL+C");

        // todo add stop condition
        while(count($this->channel->callbacks) > 0) {
            try {

                $this->channel->wait(null, false, 0.001);
            } catch (AMQPTimeoutException $e){
                // do idle event
            }
        }

        // todo run loop
        // while not stop conditions
        // wait on rabbitmq channels
        // trigger EVENT_FRAMEWORK_IDLE (so bundles have an async hook)


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
        $context = new Context($bundle, $this);
        $context->setServiceRegistry($this->getServiceRegistry());

        $this->configureContext($context, $bundle);

        $locator = new ServiceManager();
        if($bundle instanceof ConfigProviderInterface){
            $configArray = $bundle->getConfig();
            $config = new Config(@$configArray['service_manager'] ?: array());
            $config->configureServiceManager($locator);
        }

        /** @var ServiceManager $manager */
        $manager = $this->getServiceLocator();
        $manager->addPeeringServiceManager($locator, Servicemanager::SCOPE_CHILD);
        $locator->addPeeringServiceManager($manager, ServiceManager::SCOPE_PARENT);


        $context->setServiceLocator($this->getServiceLocator());

        if($bundle instanceof ActivatorProviderInterface){
            $activator = $bundle->getActivator();
            /** @var $bundle BundleInterface */
            $activator->start($context);
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

    /**
     * @param Context $context
     * @param BundleInterface $bundle
     */
    protected function configureContext(Context $context, BundleInterface $bundle)
    {
        // let bundle config override framework config
        if($bundle instanceof ConfigProviderInterface){
            $config = array_merge($this->getConfig(), $bundle->getConfig());
            $context->setConfig(new ArrayObject($config));
        } else {
            $context->setConfig($this->getConfig());
        }
        // todo override both with local config
    }
}