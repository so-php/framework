<?php


namespace Sophp\Framework\Curl\ResourceFactory;


use Zend\Uri\Uri;

interface ResourceFactoryInterface {
    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param array $options
     */
    public function setOptions($options = array());

    /**
     * @param string $option
     * @param mixed $value
     */
    public function setOption($option, $value);

    /**
     * @param Uri $uri
     * @return resource
     */
    public function build(Uri $uri = null);
} 