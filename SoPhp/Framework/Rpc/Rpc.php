<?php


namespace SoPhp\Framework\Rpc;


use PhpAmqpLib\Channel\AMQPChannel;

class Rpc {
    const EXCHANGE_NAME = 'sophp-rpc-name';

    /**
     * Initializes the RPC exchange
     * @param AMQPChannel $channel
     */
    public static function declareExchange(AMQPChannel $channel) {
        $channel->exchange_declare(self::EXCHANGE_NAME, 'topic', false, false, false);
    }

    /**
     * Converts a fully qualified class name to a route binding key
     * @param string $serviceName
     * @return string
     */
    public static function serviceNameToBindingRoute($serviceName){
        return str_replace('\\', '.', $serviceName);
    }
} 