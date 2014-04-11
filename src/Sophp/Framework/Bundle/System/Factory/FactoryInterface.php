<?php


namespace Sophp\Framework\Bundle\System\Factory;


use Sophp\Framework\Bundle\System\SystemInterface;

interface FactoryInterface {
    /**
     * @return SystemInterface
     */
    public function newSystemBundle();
} 