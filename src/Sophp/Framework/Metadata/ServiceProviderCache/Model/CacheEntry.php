<?php


namespace Sophp\Framework\Metadata\ServiceProviderCache\Model;


class CacheEntry {
    /**
     * @var string
     */
    protected $peerId;
    /**
     * @var bool
     */
    protected $canProvide;

    /**
     * @return CacheEntry
     */
    public static function build(){
        return new self();
    }

    /**
     * @param boolean $canProvide
     * @return self
     */
    public function setCanProvide($canProvide)
    {
        $this->canProvide = $canProvide;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCanProvide()
    {
        return $this->canProvide;
    }

    /**
     * @param string $peerId
     * @return self
     */
    public function setPeerId($peerId)
    {
        $this->peerId = $peerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPeerId()
    {
        return $this->peerId;
    }


} 