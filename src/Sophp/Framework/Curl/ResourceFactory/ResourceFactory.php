<?php


namespace Sophp\Framework\Curl\ResourceFactory;


use Zend\Uri\Uri;

class ResourceFactory implements ResourceFactoryInterface {
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options = array())
    {
        $this->options = $options;
    }

    /**
     * @param int $option
     * @param mixed $value
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * @param Uri $uri
     * @return resource
     */
    public function build(Uri $uri = null)
    {

        $handle = curl_init($uri ? $uri->toString() : null);

        foreach($this->options as $option => $value){
            curl_setopt($handle, $option, $value);
        }

        return $handle;
    }
}