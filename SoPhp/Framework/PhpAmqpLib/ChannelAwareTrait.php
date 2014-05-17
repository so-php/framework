<?php


namespace SoPhp\Framework\PhpAmqpLib;
use PhpAmqpLib\Channel\AMQPChannel;


/**
 * Class ChannelAwareTrait
 * @package Framework\PhpAmqpLib
 * @satisfies ChannelAwareInterface
 */
trait ChannelAwareTrait {
    /** @var  AMQPChannel */
    protected $_channel;

    /**
     * @param AMQPChannel $channel
     * @return mixed
     */
    public function setChannel(AMQPChannel $channel) {
        $this->_channel = $channel;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(){
        return $this->_channel;
    }
} 