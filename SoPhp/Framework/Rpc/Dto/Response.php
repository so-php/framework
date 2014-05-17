<?php


namespace SoPhp\Framework\Rpc\Dto;


class Response {
    /** @var bool */
    protected $isException = false;
    /** @var mixed */
    protected $rpcReturnValue = null;

    /**
     * @param mixed $rpcReturnValue
     * @param bool $isException
     */
    public function __construct($rpcReturnValue, $isException = false){
        $this->setRpcReturnValue($rpcReturnValue);
        $this->setIsException($isException);
    }

    /**
     * @return boolean
     */
    public function isIsException()
    {
        return $this->isException;
    }

    /**
     * @param boolean $isException
     * @return self
     */
    public function setIsException($isException)
    {
        $this->isException = $isException;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRpcReturnValue()
    {
        return $this->rpcReturnValue;
    }

    /**
     * @param mixed $rpcReturnValue
     * @return self
     */
    public function setRpcReturnValue($rpcReturnValue)
    {
        $this->rpcReturnValue = $rpcReturnValue;
        return $this;
    }

} 