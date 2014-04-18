<?php


namespace Sophp\Framework\Metadata\PeerRegistry\Model;


use Zend\Uri\Uri;

class Peer {
    /** @var  string */
    protected $id;
    /** @var  Uri */
    protected $uri;

    /**
     * @return Peer
     */
    public static function build(){
        return new Peer();
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Zend\Uri\Uri|string $uri
     * @throws \RuntimeException
     * @return self
     */
    public function setUri($uri)
    {
        if(is_string($uri)) {
            $this->uri = new Uri($uri);
        } else if($uri instanceof Uri) {
            $this->uri = $uri;
        } else {
            throw new \RuntimeException("URI must be either a valid URI string or instance of Zend\\Uri\\Uri");
        }
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return \Zend\Uri\Uri
     */
    public function getUri()
    {
        return $this->uri;
    }


} 