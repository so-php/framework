<?php


namespace Sophp\Framework\Metadata\Storage;

interface KeyStoreInterface {
    /**
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value);

    /**
     * @param string $key
     */
    public function remove($key);

    /**
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @return array
     */
    public function getAll();
} 