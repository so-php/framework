<?php
use PhpAmqpLib\Connection\AMQPConnection;
use SoPhp\Framework\Framework;

require_once __DIR__ .'/vendor/autoload.php';

$config = include __DIR__ . '/config/local.php';
$mq = $config['rabbitmq'];

$connection = new AMQPConnection($mq['host'], $mq['port'], $mq['user'], $mq['password']);

$framework = new Framework($connection);
$framework->setConfig(new ArrayObject($config));
// call framework activator
$framework->run();

