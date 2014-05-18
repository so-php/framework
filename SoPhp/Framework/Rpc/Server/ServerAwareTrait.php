<?php


namespace SoPhp\Framework\Rpc\Server;


use SoPhp\Framework\Rpc\Server;

trait ServerAwareTrait {
    /**
     * @var Server
     */
    private $rpcServer;

    /**
     * @param Server $server
     */
    public function setRpcServer(Server $server)
    {
        $this->rpcServer = $server;
    }

    /**
     * @return Server
     */
    public function getRpcServer()
    {
        return $this->rpcServer;
    }
}