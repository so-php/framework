<?php


namespace Test\PhpAmqpLib;

use PhpAmqpLib\Connection\AMQPConnection;

class ConnectionStub extends AMQPConnection {
    public function __construct(){}
} 