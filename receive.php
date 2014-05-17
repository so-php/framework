<?php
use SoPhp\Framework\Rpc\Server;
use SoPhp\Framework\ServiceLocator\Adapter\Stub;

require_once __DIR__ .'/bootstrap2.php';

$channel = $connection->channel();

$server = new Server();
$server->setChannel($channel);
$server->registerService('Hello\World\ServiceInterface');
$locator = new Stub();
$server->setServiceLocator($locator);

class Mock {
    public function __call($name, $params){
        return "called `$name` with parameters: " .print_r($params,true);
    }
}
$locator->setService('Hello\World\ServiceInterface', new Mock());

echo " [x] Awaiting RPC requests. To exit press CTRL+C\n";

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

exit;