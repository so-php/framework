<?php


namespace SoPhp\Framework\Rpc\Dto;


class Response {
    /** @var bool */
    protected $isFault = false;
    /** @var mixed */
    protected $rpcReturnValue = null;

    /**
     * @param mixed $rpcReturnValue
     * @param bool $isException
     */
    public function __construct($rpcReturnValue, $isException = false){
        $this->setRpcReturnValue($rpcReturnValue);
        $this->setIsFault($isException);
    }

    /**
     * @return boolean
     */
    public function isFault()
    {
        return $this->isFault;
    }

    /**
     * @param boolean $isFault
     * @return self
     */
    public function setIsFault($isFault)
    {
        $this->isFault = $isFault;
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