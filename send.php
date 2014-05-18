<?php

use SoPhp\Framework\Rpc\Client;
use SoPhp\Framework\Rpc\Exception\RpcFailure;

require_once __DIR__ .'/bootstrap2.php';
//define('AMQP_DEBUG', true);

try {
    $client = new Client('SoPhp\Bundle\Sample\Calculator\CalculatorServiceInterface');
    $client->setChannel($connection->channel());
    $sum = $client->add(7, 13);
    echo " [*] RPC Response: " . print_r($sum, true) . "\n";
} catch(RpcFailure $e) {
    echo " [!] RPC failed: " . $e ->getMessage() . PHP_EOL;
}

$connection->channel()->close();
$connection->close();


