<?php


namespace SoPhp\Framework\ServiceLocator;


/**
 * Interface ServiceLocatorPeerAwareInterface
 * @package SoPhp\Framework\ServiceLocator
 */
interface ServiceLocatorPeerAwareInterface {

    /**
     * @return ServiceLocatorInterface[]
     */
    public function getPeers();

    /**
     * @param ServiceLocatorInterface $peer
     */
    public function addPeer(ServiceLocatorInterface $peer);

    public function remove(ServiceLocatorInterface $peer);
} 