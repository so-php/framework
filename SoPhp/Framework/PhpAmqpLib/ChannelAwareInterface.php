<?php


namespace SoPhp\Framework\PhpAmqpLib;


use PhpAmqpLib\Channel\AMQPChannel;

interface ChannelAwareInterface {
    /**
     * @param AMQPChannel $channel
     * @return mixed
     */
    public function setChannel(AMQPChannel $channel);

    /**
     * @return AMQPChannel
     */
    public function getChannel();
} 