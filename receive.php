<?php
use SoPhp\Bundle\Sample\Calculator\CalculatorService;
use SoPhp\Framework\Rpc\Server;
use SoPhp\Framework\ServiceLocator\Adapter\Stub;

require_once __DIR__ .'/bootstrap2.php';

$channel = $connection->channel();

$server = new Server();
$server->setChannel($channel);
$server->registerService('\SoPhp\Bundle\Sample\Calculator\CalculatorServiceInterface');
$locator = new Stub();
$server->setServiceLocator($locator);

$locator->setService('\SoPhp\Bundle\Sample\Calculator\CalculatorServiceInterface',
    new CalculatorService());
var_dump($locator->get('SoPhp\Bundle\Sample\Calculator\CalculatorServiceInterface'));

echo " [x] Awaiting RPC requests. To exit press CTRL+C\n";

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

exit;