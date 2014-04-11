<?php


namespace Sophp\Framework\Bundle\System\Factory;


use Sophp\Framework\Bundle\System\System;
use Sophp\Framework\Bundle\System\SystemInterface;

class Factory implements FactoryInterface {

    /**
     * @return SystemInterface
     */
    public function newSystemBundle()
    {
        return new System();
    }
}