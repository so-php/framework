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

        $result = curl_exec($handle);

        curl_close($handle);

        return $result;
    }

    // TODO helper methods for setting URI, METHOD,
}