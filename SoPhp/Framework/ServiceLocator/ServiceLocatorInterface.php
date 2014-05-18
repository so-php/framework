<?php


namespace SoPhp\Framework\ServiceLocator;


interface ServiceLocatorInterface {
    /**
     * @param string $serviceName
     * @return mixed
     */
    public function get($serviceName);

    /**
     * @param string $serviceName
     * @return bool
     */
    public function canCreate($serviceName);

    /**
     * @param string $serviceName
     * @param mixed $instance
     */
    public function setService($serviceName, $instance);

    /**
     * @param string $serviceName
     */
    public function unsetService($serviceName);

    /**
     * @return string
     */
    public function getId();

} 