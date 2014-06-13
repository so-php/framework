<?php
use SoPhp\Amqp\EndpointDescriptor;
use SoPhp\Rpc\Client;
use SoPhp\Rpc\Exception\Server\TimeoutException;
use SoPhp\ServiceRegistry\Entry;
use SoPhp\ServiceRegistry\ServiceRegistry;

require_once 'bootstrap2.php';

define('SERVICE', '\SoPhp\Bundle\Sample\Calculator\CalculatorServiceInterface');

if(count($argv) < 4){
    echo "Usage:\n\tphp calculator.php <number> <opp -+*/> <number>\n\tex: calculator.php 3 + 7\n\tex: calculator.php 4 * 5\n\n";
    die;
}
$a = @$argv[1];
$opp = @$argv[2];
$b = @$argv[3];
if(!is_numeric($a)){die("The first parameter must be a number.");}
if(!in_array($opp, array('-','+','/','*'))){die("The second parameter must be one of -,+,/,*");}
if(!is_numeric($b)){die("The third parameter must be a number.");}

switch ($opp) {
    case '-':
        $method = 'subtract';
        break;
    case '+':
        $method = 'add';
        break;
    case '*':
        $method = 'multiply';
        break;
    case '/':
        $method = 'divide';
        break;
}

$registry = new ServiceRegistry($ch, $mongo);
/*
foreach($registry->query() as $registration){
    echo "found " . $registration->getServiceName() . "\n";
}
*/
$registrations = $registry->queryForName('\\SoPhp\\Bundle\\Sample\\CalculatorServiceInterface');

if(empty($registrations)){
    die("Could not find any services for " . SERVICE);
}

foreach($registrations as $registration) {
    echo "found " . $registration->getServiceName() . "\n";
    try {
        $result = $registration->getService()->call($method, array($a, $b)) . PHP_EOL;
        echo "$a $opp $b = " . $result . "\n";
        exit;
    } catch (TimeoutException $e) {
        echo "Unregistered {$registration->getServiceName()} for instance " . $registration->getProcessId() . "\n";
        $registration->unregister();
    }
}
echo "Services timed out\n";
