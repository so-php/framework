<?php


namespace SoPhp\Framework\Rpc\Dto;


class Fault {
    /** @var  string */
    protected $file;
    /** @var  string */
    protected $line;
    /** @var  string */
    protected $message;
    /** @var  string */
    protected $stringTrace;
    /** @var  string */
    protected $exceptionClass;

    // restrict instantiating to factory method
    protected function __construct(){}

    /**
     * Create a fault from an exception
     * @param \Exception $e
     * @return Fault
     */
    public static function factory(\Exception $e){
        $fault = new Fault();
        $fault->setFile($e->getFile());
        $fault->setLine($e->getLine());
        $fault->setMessage($e->getMessage());
        $fault->setStringTrace($e->getTraceAsString());
        $fault->setExceptionClass(get_class($e));
        return $fault;
    }

    /**
     * @return string
     */
    public function getExceptionClass()
    {
        return $this->exceptionClass;
    }

    /**
     * @param string $exceptionClass
     * @return self
     */
    public function setExceptionClass($exceptionClass)
    {
        $this->exceptionClass = $exceptionClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return self
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param string $line
     * @return self
     */
    public function setLine($line)
    {
        $this->line = $line;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getStringTrace()
    {
        return $this->stringTrace;
    }

    /**
     * @param string $stringTrace
     * @return self
     */
    public function setStringTrace($stringTrace)
    {
        $this->stringTrace = $stringTrace;
        return $this;
    }


} 