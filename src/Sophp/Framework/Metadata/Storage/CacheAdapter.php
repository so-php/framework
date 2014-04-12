<?php


namespace Sophp\Framework\Metadata\Storage;


use Zend\Cache\Storage\StorageInterface;

class CacheAdapter implements KeyStoreInterface {
    /** @var  StorageInterface */
    protected $cache;
    /** @var  string */
    protected $key;

    /**
     * @param StorageInterface $cache
     * @param string $key
     */
    public function __construct(StorageInterface $cache, $key){
        $this->setCache($cache);
        $this->setKey($key);
    }

    /**
     * @param \Zend\Cache\Storage\StorageInterface $cache
     * @return self
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return \Zend\Cache\Storage\StorageInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param string $key
     * @return self
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }


    /**
     * @param string $key
     * @param mixed $value
     * @throws \RuntimeException
     */
    public function add($key, $value)
    {
        $updated = false;
        $success = false;
        $token = null;
        while(!$updated) {
            $keyStore = $this->getCache()->getItem($this->getKey(), $success, $token);
            if(!$success || !is_array($keyStore)){
                $keyStore = array();
            }
            $keyStore[$key] = $value;
            $updated = $this->getCache()->checkAndSetItem($token, $this->getKey(), $keyStore);
        }
    }

    /**
     * @param string $key
     * @throws \RuntimeException
     */
    public function remove($key)
    {
        $updated = false;
        $success = false;
        $token = null;
        while(!$updated) {
            $keyStore = $this->getCache()->getItem($this->getKey(), $success, $token);
            if(!$success){
                $keyStore = array();
            } else {
                unset($keyStore[$key]);
            }
            $updated = $this->getCache()->checkAndSetItem($token, $this->getKey(), $keyStore);
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $store = $this->getCache()->getItem($this->getKey());
        return isset($store[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $store = $this->getCache()->getItem($this->getKey());
        return isset($store[$key]) ? $store[$key] : null;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->getCache()->getItem($this->getKey()) ?: array();
    }
}