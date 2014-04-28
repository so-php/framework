<?php


namespace Sophp\Framework\Bundle\Loader;

use RecursiveDirectoryIterator;
use ReflectionClass;
use Sophp\Framework\Bundle\BundleInterface;


class Loader {
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
        // TODO make source dir configurable
        // iterate through vendor folder
        $srcDir = __DIR__ . '/../../../../vendor/';
        $directoryIterator = new RecursiveDirectoryIterator($srcDir);
        $iteratorIterator = new \RecursiveIteratorIterator($directoryIterator);
        $iteratorIterator->setMaxDepth(3); // src/vendor/package/*
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
} 