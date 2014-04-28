<?php


namespace SoPhp\Framework\ServiceDiscovery;


use PhpAmqpLib\Connection\AMQPConnection;

class ServiceDiscovery {
    const EXCHANGE_BROADCAST = 'sophp.service.discovery.broadcast';
    const EXCHANGE_RECEIVE = 'sophp.service.discovery.receive';


    /**
     * @var AMQPConnection
     */
    protected $connection;

    public function __construct(AMQPConnection $connection){
        $this->connection = $connection;
    }
} 