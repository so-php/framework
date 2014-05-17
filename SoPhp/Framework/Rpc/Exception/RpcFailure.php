<?php


namespace SoPhp\Framework\Rpc\Exception;


use RuntimeException;

class RpcFailure extends RuntimeException {

    /**
     * @param \Exception $response
     * @return RpcFailure
     */
    public static function generic(\Exception $response)
    {
        return new self("RPC Failure", 0, $response);
    }
}