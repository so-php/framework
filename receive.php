<?php
require_once __DIR__ .'/bootstrap.php';
echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
    echo ' [x] Received ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done", "\n";
    // don't ack to see what happens
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

};

// generate a private queue just for this process which will be deleted when process ends
list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
echo " [x] created queue $queue_name.\n";

$binding_key = '#';// 'test.abc';
$channel->queue_bind($queue_name, TOPIC_NAME, $binding_key);

$channel->basic_qos(null, 1, null);
$channel->basic_consume($queue_name, '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}