<?php
use SoPhp\Framework\Rpc\Server;

require_once __DIR__ .'/bootstrap2.php';

$channel = $connection->channel();

$server = new Server();
$server->setChannel($channel);
$server->registerService('Hello\World\ServiceInterface');
$server->setServiceLocator(new SoPhp\Framework\ServiceLocator\Adapter\Stub());

echo " [x] Awaiting RPC requests. To exit press CTRL+C\n";

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

exit;