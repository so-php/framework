<?php


namespace Sophp\Framework\Curl;


use Sophp\Framework\Curl\ResourceFactory\ResourceFactory;
use Sophp\Framework\Curl\ResourceFactory\ResourceFactoryInterface;
use Zend\Uri\Uri;

class Curl implements ResourceFactoryInterface {
    /**
     * @var ResourceFactoryInterface
     */
    protected $resourceFactory;

    /**
     * @return ResourceFactoryInterface
     */
    public function getResourceFactory()
    {
        if(!$this->resourceFactory) {
            $this->resourceFactory = new ResourceFactory();
        }
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
        $handle = $this->build();

        $result = $this->curlExec($handle);

        $this->curlClose($handle);

        return $result;
    }

    /**
     * Native function wrapper for testing
     * @param $handle
     * @return mixed
     */
    protected function curlExec($handle){
        return curl_exec($handle);
    }

    /**
     * Native function wrapper for testing
     * @param $handle
     */
    protected function curlClose($handle){
        curl_close($handle);
    }

    // TODO helper methods for setting URI, METHOD,
}