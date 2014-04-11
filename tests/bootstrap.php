<?php
use Zend\Loader\StandardAutoloader;

chdir(__DIR__);
defined('HOME') ?: define('HOME', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);

require_once HOME . '/vendor/autoload.php';

print_r(realpath( HOME . 'tests/'));

$autoloader = new StandardAutoloader();
$autoloader->registerNamespace('Sophp', HOME . 'src/Sophp');
$autoloader->registerNamespace('Unit', HOME . 'tests/Unit');
$autoloader->registerNamespace('Integration', HOME . 'tests/Integration');
$autoloader->register();

date_default_timezone_set('UTC');