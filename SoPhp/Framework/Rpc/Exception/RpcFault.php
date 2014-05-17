<?php


namespace SoPhp\Framework\Rpc\Exception;


use SoPhp\Framework\Rpc\Dto\Fault;

class RpcFault extends RpcFailure {
    /** @var  Fault */
    protected $fault;

    /**
     * @return Fault
     */
    public function getFault()
    {
        return $this->fault;
    }

    /**
     * @param Fault $fault
     * @return self
     */
    public function setFault($fault)
    {
        $this->fault = $fault;
        return $this;
    }

    /**
     * @param Fault $fault
     */
    public function __construct(Fault $fault){
        parent::__construct($fault->getMessage());
        $this->setFault($fault);
    }
} 