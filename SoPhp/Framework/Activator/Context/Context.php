<?php


namespace SoPhp\Framework\Activator\Context;


use PhpAmqpLib\Channel\AMQPChannel;
use SoPhp\Framework\Bundle\BundleInterface;
use SoPhp\Framework\Config\ConfigAwareInterface;
use SoPhp\Framework\Config\ConfigAwareTrait;
use SoPhp\Framework\FrameworkInterface;
use SoPhp\Framework\Logger\LazyLoggerProviderTrait;
use SoPhp\Framework\Logger\LoggerAwareInterface;
use SoPhp\ServiceRegistry\ServiceRegistryAwareInterface;
use SoPhp\ServiceRegistry\ServiceRegistryAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


class Context implements ServiceLocatorAwareInterface, ServiceRegistryAwareInterface,
    ConfigAwareInterface, LoggerAwareInterface {
    use LazyLoggerProviderTrait;
    use ServiceLocatorAwareTrait;
    use ConfigAwareTrait;
    use ServiceRegistryAwareTrait;

    /** @var  FrameworkInterface */
    protected $framework;
    /** @var  BundleInterface */
    protected $bundle;

    /**
     * @param BundleInterface $bundle
     * @param FrameworkInterface $framework
     */
    public function __construct(BundleInterface $bundle, FrameworkInterface $framework){
        $this->setBundle($bundle);
        $this->setFramework($framework);
        $bundle->setContext($this);
    }

    /**
     * @return BundleInterface
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @param BundleInterface $bundle
     * @return self
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
        return $this;
    }

    /**
     * @return FrameworkInterface
     */
    public function getFramework()
    {
        return $this->framework;
    }

    /**
     * @param FrameworkInterface $framework
     * @return self
     */
    public function setFramework($framework)
    {
        $this->framework = $framework;
        return $this;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->getFramework()->getChannel();
    }


} 