<?php


namespace SoPhp\Framework\Rpc\Server;


use SoPhp\Framework\Rpc\Server;

interface ServerAwareInterface {
    /**
     * @param Server $server
     */
    public function setRpcServer(Server $server);

    /**
     * @return Server
     */
    public function getRpcServer();
} 