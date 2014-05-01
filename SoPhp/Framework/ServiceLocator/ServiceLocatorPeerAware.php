<?php


namespace SoPhp\Framework\ServiceLocator;


trait ServiceLocatorPeerAware {
    /** @var  ServiceLocatorInterface[] */
    protected $peers;

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
     * @param $serviceName
     * @return bool
     */
    protected function canPeerCreate($serviceName){
        foreach($this->peers as $peer){
            /** @var $peer ServiceLocatorInterface */
            if($peer->canCreate($serviceName)){
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $serviceName
     * @throws \RuntimeException
     * @return mixed
     */
    protected function peerCreate($serviceName){
        foreach($this->peers as $peer){
            /** @var $peer ServiceLocatorInterface */
            if($peer->canCreate($serviceName)){
                return $peer->get($serviceName);
            }
        }
        throw new \RuntimeException("Cannot create instance of `$serviceName`");
    }
} 