<?php
chdir(__DIR__);
defined('HOME') ?: define('HOME', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);

// deal with vagrant/phpstorm/remote testing madness
$loaders = preg_grep('/ComposerAutoloader/', get_declared_classes());
if(empty($loaders)) {
    $loader = require HOME . '/vendor/autoload.php';
} else {
    $class = array_shift($loaders);
    $loader = $class::getLoader();
}

$loader->addPsr4('Test\\', __DIR__ . '/Test');


date_default_timezone_set('UTC');
 