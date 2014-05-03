<?php


namespace SoPhp\Framework\ServiceLocator;


use SoPhp\Framework\ServiceLocator\CyclicalResolution\CyclicalResolution;

/**
 * Trait ServiceLocatorPeerAwareTrait
 * @package SoPhp\Framework\ServiceLocator
 * @satisfies SoPhp\Framework\ServiceLocator\ServiceLocatorPeerAwareInterface
 */
trait ServiceLocatorPeerAwareTrait {
    /** @var  ServiceLocatorInterface[] */
    protected $peers = array();

    /**
     * @return ServiceLocatorInterface[]
     */
    public function getPeers(){
        return $this->peers;
    }

    /**
     * @param ServiceLocatorInterface $peer
     */
    public function addPeer(ServiceLocatorInterface $peer){
        if(in_array($peer, $this->peers)){
            return;
        }
        array_push($this->peers, $peer);
    }

    public function remove(ServiceLocatorInterface $peer){
        // TODO
    }

    /**
     * @param string $serviceName
     * @param CyclicalResolution $cyclicalResolution
     * @return bool
     */
    protected function canPeerCreate($serviceName, CyclicalResolution $cyclicalResolution){
        foreach($this->peers as $peer){
            /** @var $peer ServiceLocatorInterface */
            if($peer->canCreate($serviceName, $cyclicalResolution)){
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $serviceName
     * @param CyclicalResolution $cyclicalResolution
     * @throws \RuntimeException
     * @return mixed
     */
    protected function peerCreate($serviceName, CyclicalResolution $cyclicalResolution){
        foreach($this->peers as $peer){
            /** @var $peer ServiceLocatorInterface */
            if($peer->canCreate($serviceName, $cyclicalResolution)){
                return $peer->get($serviceName);
            }
        }
        throw new \RuntimeException("Cannot create instance of `$serviceName`");
    }
} 