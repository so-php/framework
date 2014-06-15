<?php
use SoPhp\Amqp\EndpointDescriptor;
use SoPhp\Bundle\Sample\Calculator\CalculatorServiceInterface;
use SoPhp\Rpc\Client;
use SoPhp\Rpc\Exception\Server\TimeoutException;
use SoPhp\Rpc\Proxy\ProxyAbstract;
use SoPhp\ServiceRegistry\Entry;
use SoPhp\ServiceRegistry\ServiceRegistry;
use Zend\ServiceManager\ServiceManager;
use SoPhp\ServiceRegistry\AbstractFactory\ServiceRegistry as ServiceRegistryFactory;

require_once 'bootstrap2.php';

define('SERVICE', '\\SoPhp\\Bundle\\Sample\\CalculatorServiceInterface');

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


$registry = new ServiceRegistry($ch, $mongo);
$factory = new ServiceRegistryFactory($registry);
$manager = new ServiceManager();
$manager->addAbstractFactory($factory);
$manager->setAllowOverride(true);
$manager->setShareByDefault(false);
try {
    /** @var CalculatorServiceInterface $calculator */
    $calculator = $manager->get(SERVICE);
}catch (\Exception $e) {
    echo "No servers available.\n";
    exit;
}

switch ($opp) {
    case '-':
        $result = $calculator->subtract($a, $b);
        break;
    case '+':
        $result = $calculator->add($a, $b);
        break;
    case '*':
        $result = $calculator->multiply($a, $b);
        break;
    case '/':
        $result = $calculator->divide($a, $b);
        break;
    default:
        $result = 'undefined';
}
/** @var ProxyAbstract $calculator  */
echo "$a $opp $b = " . $result . "\t" . "[answered by: " . $calculator->__getService()->getEndpoint() . "]\n";

