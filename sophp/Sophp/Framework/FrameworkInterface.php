<?php


namespace Sophp\Framework;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use Sophp\Framework\Bundle\BundleInterface;

interface FrameworkInterface {
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
} 