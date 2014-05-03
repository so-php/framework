<?php


namespace SoPhp\Framework\Bundle\Loader;

use SoPhp\Framework\Config\ConfigAwareTrait;
use SoPhp\Framework\Config\Exception\InvalidDirectiveException;
use SoPhp\Framework\Config\Exception\MissingDirectiveException;
use RecursiveDirectoryIterator;
use ReflectionClass;
use SoPhp\Framework\Bundle\BundleInterface;


class Loader {
    use ConfigAwareTrait;

    /**
     * @return BundleInterface[]
     */
    public function load(){
        $existingClasses = get_declared_classes();

        $this->requireBundles();

        $newClasses = array_diff(get_declared_classes(), $existingClasses);

        $bundles = array();
        foreach($newClasses as $className) {
            $reflectionClass = new ReflectionClass($className);
            if(strtolower($reflectionClass->getShortName()) == 'bundle'){
                $instance = new $className;
                $bundles[] = $instance;
            }
        }
        return $bundles;
    }

    /**
     * Scour the search dir for Bundle.php files and load them
     */
    protected function requireBundles()
    {
        // iterate through vendor folder
        $srcDir = $this->getSearchPath();
        $directoryIterator = new RecursiveDirectoryIterator($srcDir);
        $iteratorIterator = new \RecursiveIteratorIterator($directoryIterator);
        $iteratorIterator->setMaxDepth($this->getSearchDepth()); // src/vendor/package/*
        foreach($iteratorIterator as $entry) {
            /** @var $entry RecursiveDirectoryIterator  */
            if($entry->isFile()
                && strtolower($entry->getFilename()) == 'bundle.php'
            )
            {
                //echo " [x] Found Bundle: " . $entry->getRealPath() . "\n";
                require_once $entry->getRealPath();
            }
        }
    }

    /**
     * @return string
     * @throws \SoPhp\Framework\Config\Exception\MissingDirectiveException
     * @throws \SoPhp\Framework\Config\Exception\InvalidDirectiveException
     */
    protected function getSearchPath(){
        $config = $this->getConfig();
        if(!isset($config['bundles']['deployDir'])){
            throw new MissingDirectiveException('bundles.deployDir');
        }
        $path = realpath($config['bundles']['deployDir']);
        if(!file_exists($path)){
            throw new InvalidDirectiveException('bundles.deployDir', 'Directory does not exist');
        }
        return $path;
    }

    protected function getSearchDepth(){
        $config = $this->getConfig();
        if(!isset($config['bundles']['searchDepth'])){
            throw new MissingDirectiveException('bundles.searchDepth');
        }
        $depth = $config['bundles']['searchDepth'];
        if(!is_int($depth) || $depth < 0){
            throw new InvalidDirectiveException('bundles.searchDepth', 'Depth must be an positive integer value');
        }
        return $depth;
    }
} 