<?php


namespace Sophp\Framework\Curl\MultiCurl;


use Sophp\Framework\Curl\ResourceFactory\ResourceFactoryInterface;
use Zend\Uri\Uri;

class MultiCurl implements ResourceFactoryInterface {
    /** @var  ResourceFactoryInterface */
    protected $resourceFactory;

    /**
     * @var Uri[]
     */
    protected $uris = array();

    /**
     * @return ResourceFactoryInterface
     */
    public function getResourceFactory()
    {
        return $this->resourceFactory;
    }

    /**
     * @param ResourceFactoryInterface $resourceFactory
     * @return self
     */
    public function setResourceFactory($resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;
        return $this;
    }

    /**
     * @return \Zend\Uri\Uri[]
     */
    public function getUris()
    {
        return $this->uris;
    }

    /**
     * @param \Zend\Uri\Uri[] $uris
     * @return self
     */
    public function setUris($uris)
    {
        $this->uris = $uris;
        return $this;
    }

    /**
     * @param Uri $uri
     */
    public function addUri(Uri $uri){
        array_push($this->uris, $uri);
    }


    public function clearUris(){
        $this->uris = array();
    }


    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->getResourceFactory()->getOptions();
    }

    /**
     * @param array $options
     */
    public function setOptions($options = array())
    {
        $this->getResourceFactory()->setOptions($options);
    }

    /**
     * @param string $option
     * @param mixed $value
     */
    public function setOption($option, $value)
    {
        $this->getResourceFactory()->setOption($option, $value);
    }

    /**
     * @param Uri $uri
     * @return resource
     */
    public function build(Uri $uri = null)
    {
        return $this->getResourceFactory()->build($uri);
    }

    /**
     * @return bool|string
     */
    public function exec(){
        $multiHandle = curl_multi_init();

        $handles = array();
        foreach($this->uris as $uri){
            $handle = $this->build();
            curl_multi_add_handle($multiHandle, $handle);
            $handles[] = $handle;
        }

        curl_multi_exec($multiHandle, $stillRunning);
        $status = new Status($multiHandle, $stillRunning, $handles);
        return $status;
    }
}