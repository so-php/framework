<?php


namespace Sophp\Framework\EventManager\Client;


use Zend\Uri\Uri;

interface ClientInterface {
    public function addEndpoint(Uri $uri);
    public function setParameters();
    public function execute();
}