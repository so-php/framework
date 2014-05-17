<?php


namespace SoPhp\Framework\Rpc\Dto;


class Request {
    /** @var  string */
    protected $class;
    /** @var  string */
    protected $method;
    /** @var  string */
    protected $params;

    public function __construct($class, $method, $params){
        $this->setClass($class);
        $this->setMethod($method);
        $this->setParams($params);
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return self
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $params
     * @return self
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

} 