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

        $handle = $this->curlInit($uri ? $uri->toString() : null);

        foreach($this->options as $option => $value){
            $this->curlSetOpt($handle, $option, $value);
        }

        return $handle;
    }

    /**
     * Native method wrapper for testing
     * @param null $uri
     * @return resource
     */
    protected function curlInit($uri = null){
        return curl_init($uri);
    }

    /**
     * Native method wrapper for testing
     * @param $handle
     * @param int $option
     * @param $value
     * @return bool
     */
    protected function curlSetOpt($handle, $option, $value){
        return curl_setopt($handle, $option, $value);
    }
}