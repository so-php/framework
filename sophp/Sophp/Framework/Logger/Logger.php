<?php


namespace Sophp\Framework\Logger;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class Logger {
    const LEVEL_ERROR = 1;
    const LEVEL_WARN = 2;
    const LEVEL_INFO = 3;
    const LEVEL_TRACE = 4;

    const EXCHANGE_NAME = 'sophp.framework.logger';

    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var AMQPMessage
     */
    protected $message;

    /**
     * @param AMQPChannel $channel
     */
    public function __construct(AMQPChannel $channel) {
        $this->setChannel($channel);
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
     * @return Logger
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        self::declareExchange($this->channel);

        return $this;
    }

    /**
     * @param AMQPChannel $channel
     * Publicise exchange declaration so anything interested in exchange can make
     * sure iti s declared before binding to it.
     */
    public static function declareExchange(AMQPChannel $channel) {
        $channel->exchange_declare(self::EXCHANGE_NAME, 'fanout', false, true, false);
    }

    /**
     * @param $msg
     */
    public function trace($msg){
        $this->message(self::LEVEL_TRACE, $msg);
    }

    /**
     * @param $msg
     */
    public function info($msg){
        $this->message(self::LEVEL_INFO, $msg);
    }

    /**
     * @param $msg
     */
    public function warn($msg){
        $this->message(self::LEVEL_WARN, $msg);
    }

    /**
     * @param $msg
     */
    public function error($msg){
        $this->message(self::LEVEL_ERROR, $msg);
    }

    /**
     * @param int $priority
     * @param string $message
     */
    protected function message($priority, $message){
        $msg = $this->getMessage("$priority: $message");

        $this->getChannel()->basic_publish($msg, self::EXCHANGE_NAME);
    }

    /**
     * @param $body
     * @return AMQPMessage
     */
    protected function getMessage($body){
        if(!$this->message){
            $this->message = new AMQPMessage($body, array(
                'delivery_mode' => 2 // persist messages
            ));
        } else {
            $this->message->body = $body;
        }
        return $this->message;
    }
} 