<?php


namespace Sophp\Framework\Metadata\PeerRegistry\Adapter;

use Sophp\Framework\Metadata\PeerRegistry\Model\Peer;
use Sophp\Framework\Metadata\PeerRegistry\PeerRegistryInterface;

/**
 * Class Memory
 * @package Sophp\Framework\Metadata\PeerRegistery\Adapter
 * A memory based adapter for peer registry storage -- should only be used for
 * (unit/integration)testing.
 */
class Memory implements PeerRegistryInterface {
    /**
     * @var array
     */
    protected $peers = array();

    /**
     * @param Peer $peer
     */
    public function register(Peer $peer)
    {
        array_push($this->peers, $peer);
    }

    /**
     * @param Peer $peer
     */
    public function unregister(Peer $peer)
    {
        $index = array_search($peer, $this->peers, false);
        if($index !== false){
            unset( $this->peers[$index] );
        }
    }

    /**
     * @return Peer[]
     */
    public function getList()
    {
        return $this->peers;
    }
}