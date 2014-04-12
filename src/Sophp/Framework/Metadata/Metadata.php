<?php


namespace Sophp\Framework\Metadata;


use Sophp\Framework\Metadata\Model\Peer;
use Sophp\Framework\Metadata\Storage\CacheAdapter;
use Sophp\Framework\Metadata\Storage\KeyStoreInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\StorageFactory;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Metadata implements ServiceLocatorAwareInterface {
    const CACHE_CONFIG_KEY = 'sophp-metadata-cache';
    const CACHE_KEY_PEER_STORAGE = 'sophp-metadata-cache-peers';

    /** @var  ServiceLocatorInterface */
    protected $serviceLocator;
    /** @var  KeyStoreInterface */
    protected $peerStorage;


    /**
     * @return StorageInterface
     */
    protected function getStorage(){
        if(!isset($this->storage)){
            $config = $this->getServiceLocator()->get('config');
            $this->storage = StorageFactory::factory($config['sophp-metadata-cache']);
        }
        return $this->storage;
    }

    /**
     * @return CacheAdapter|KeyStoreInterface
     */
    protected function getPeerStorage(){
        if(!$this->peerStorage){
            $this->peerStorage = new CacheAdapter($this->getStorage(), self::CACHE_KEY_PEER_STORAGE);
        }
        return $this->peerStorage;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator){
        $this->setServiceLocator($serviceLocator);
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @return Peer[]
     */
    public function getRegisteredPeers(){
        return $this->getPeerStorage()->getAll();
    }

    /**
     * @param Peer $peer
     */
    public function registerPeer(Peer $peer) {
        $this->getPeerStorage()->add($peer->getId(), $peer);
    }

    /**
     * @param Peer $peer
     */
    public function unregisterPeer(Peer $peer) {
        $this->getPeerStorage()->remove($peer->getId());
    }
}