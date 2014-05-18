<?php


namespace SoPhp\Framework\ServiceLocator\Adapter;


use SoPhp\Framework\Config\ConfigAwareTrait;
use SoPhp\Framework\ServiceLocator\CyclicalResolution\CyclicalResolution;
use SoPhp\Framework\ServiceLocator\ServiceLocatorInterface;
use SoPhp\Framework\ServiceLocator\ServiceLocatorPeerAwareTrait;
use SoPhp\Framework\ServiceLocator\ServiceLocatorPeerAwareInterface;

class Stub  implements ServiceLocatorInterface, ServiceLocatorPeerAwareInterface
{
    use ConfigAwareTrait;
    use ServiceLocatorPeerAwareTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var mixed[]
     */
    protected $instances;

    public function __construct()
    {
        $this->id = spl_object_hash($this) . '.' . uniqid();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function get($serviceName)
    {
        $cname = $this->sanitize($serviceName);
        if (!isset($this->instances[$cname])) {
            $this->instances[$cname] = $this->create($serviceName);
        }
        return $this->instances[$cname];
    }

    /**
     * Test if instance already exists in locator
     * @param $serviceName
     * @return bool
     */
    public function hasInstance($serviceName){
        $cname = $this->sanitize($serviceName);
        return isset($this->instances[$cname]);
    }

    /**
     * @param string $serviceName
     * @throws \RuntimeException
     * @return mixed
     */
    protected function create($serviceName)
    {
        if (class_exists($serviceName)) {
            try {
                return new $serviceName();
            } catch (\Exception $e) {
                throw new \RuntimeException("Cannot create service `$serviceName`, " . $e->getMessage(), 0, $e);
            }
        } else {
            $cyclicalResolution = new CyclicalResolution();
            $cyclicalResolution->addReference($this);
            $instance = $this->peerCreate($serviceName, $cyclicalResolution);
            if($instance != null){
                return $instance;
            }
        }
        throw new \RuntimeException("Cannot create service `$serviceName`, class does not exist.");
    }

    /**
     * @param $name
     * @return string
     */
    protected function sanitize($name)
    {
        return ltrim(strtolower($name), '\\');
    }

    /**
     * @param string $serviceName
     * @param CyclicalResolution $cyclicalResolution
     * @return bool
     */
    public function canCreate($serviceName, CyclicalResolution $cyclicalResolution = null)
    {
        if ($cyclicalResolution && $cyclicalResolution->hasReference($this)) {
            return false;
        }

        if($this->hasInstance($serviceName)){
            return true;
        }

        if (!class_exists($serviceName)) {
            if (!$cyclicalResolution) {
                $cyclicalResolution = new CyclicalResolution();
            }
            $cyclicalResolution->addReference($this);

            return $this->canPeerCreate($serviceName, $cyclicalResolution);
        }

        $reflectionClass = new \ReflectionClass($serviceName);
        return $reflectionClass->isInstantiable();
    }

    /**
     * Register service instance
     * @param string $serviceName
     * @param mixed $instance
     */
    public function setService($serviceName, $instance){
        $cname = $this->sanitize($serviceName);
        $this->instances[$cname] = $instance;
    }

    /**
     * @param string $serviceInterface
     */
    public function unsetService($serviceName)
    {
        $cname = $this->sanitize($serviceName);
        unset($this->instances[$cname]);
    }


}