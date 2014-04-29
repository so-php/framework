<?php


namespace Test\SoPhp\Framework\Bundle;


use SoPhp\Framework\Bundle\AutoloaderProviderInterface;

class BundleWithAutoloader extends Bundle implements AutoloaderProviderInterface {

    public function getAutoloader()
    {
        // TODO: Implement getAutoloader() method.
    }
}