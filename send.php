<?php

use Sophp\Framework\Bootstrap;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ .'/bootstrap.php';

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "Hello World!";


$msg = new AMQPMessage($data, array(
    'delivery_mode' => 2 // persist messages
));

$routing_key = 'test.abc123';

$channel->basic_publish($msg, TOPIC_NAME, $routing_key);


echo " [x] Sent '".$data."'\n";

$channel->close();
$connection->close();