<?php

use SoPhp\Framework\Rpc\Client;
use SoPhp\Framework\Rpc\Exception\RpcFailure;

require_once __DIR__ .'/bootstrap2.php';
//define('AMQP_DEBUG', true);

//try {
    $client = new Client('Hello\World\ServiceInterface');
    $client->setChannel($connection->channel());
    $r = $client->greet("Hello!");
    echo " [*] RPC Response: " . print_r($r, true) . "\n";
//} catch(RpcFailure $e) {
//    echo " [!] RPC failed: " . $e ->getMessage() . PHP_EOL;
//}

$connection->channel()->close();
$connection->close();


