<?php


namespace SoPhp\Framework\Logger\Listener;


class Console extends ListenerAbstract {
    /**
     * Message handler
     * @param $msg
     */
    public function onMessage($msg){
        echo ' [x] ', $msg->body, "\n";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }
} 