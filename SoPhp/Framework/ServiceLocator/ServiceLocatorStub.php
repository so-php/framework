<?php


namespace SoPhp\Framework\ServiceLocator;


use SoPhp\Framework\Config\ConfigAware;

class ServiceLocatorStub implements ServiceLocatorInterface {
    use ConfigAware;

    /**
     * @var mixed[]
     */
    protected $instances;

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function get($serviceName)
    {
        $cname = $this->sanitize($serviceName);
        if(!isset($this->instances[$cname])){
            $this->instances[$cname] = $this->create($serviceName);
        }
    }

    /**
     * @param string $serviceName
     * @throws \RuntimeException
     * @return mixed
     */
    protected function create($serviceName){
        if(class_exists($serviceName)){
            try {
                return new $serviceName();
            } catch (\Exception $e) {
                throw new \RuntimeException("Cannot create service `$serviceName`, ". $e->getMessage(), 0, $e);
            }
        }
        throw new \RuntimeException("Cannot create service `$serviceName`, class does not exist.");
    }

    /**
     * @param $name
     * @return string
     */
    protected function sanitize($name){
        return strtolower($name);
    }
}