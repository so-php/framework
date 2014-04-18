<?php


namespace Sophp\Framework\Metadata\PeerRegistry;


use Sophp\Framework\Metadata\PeerRegistry\Model\Peer;

interface PeerRegistryInterface {
    /**
     * @param Peer $peer
     */
    public function register(Peer $peer);

    /**
     * @param Peer $peer
     */
    public function unregister(Peer $peer);

    /**
     * @return Peer[]
     */
    public function getList();
} 