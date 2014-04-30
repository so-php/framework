<?php


namespace SoPhp\Framework;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use SoPhp\Framework\Bundle\BundleInterface;
use SoPhp\Framework\Config\ConfigAwareInterface;
use SoPhp\Framework\ServiceLocator\ServiceLocatorInterface;

interface FrameworkInterface extends ConfigAwareInterface {
    /**
     * @return BundleInterface[]
     */
    public function getBundles();

    /**
     * @return AMQPConnection
     */
    public function getConnection();

    /**
     * @return AMQPChannel
     */
    public function getChannel();

    /**
     * @param BundleInterface $bundle
     */
    public function load(BundleInterface $bundle);

    /**
     * @param BundleInterface $bundle
     */
    public function start(BundleInterface $bundle);

    /**
     * @param BundleInterface $bundle
     */
    public function stop(BundleInterface $bundle);

    /**
     * Copied from ServiceAware
     */
    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator();

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator);
} 