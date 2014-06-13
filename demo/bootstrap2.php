<?php
use PhpAmqpLib\Connection\AMQPConnection;

require_once __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/../config/local.php';
$mq = $config['rabbitmq'];

$connection = new AMQPConnection($mq['host'], $mq['port'], $mq['user'], $mq['password']);

$ch = $connection->channel();

$mongo = new \SoPhp\ServiceRegistry\Storage\Mongo\Mongo();

