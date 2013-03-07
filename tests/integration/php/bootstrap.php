<?php
set_include_path(
    realpath(dirname(__FILE__) . '/../../../sources')
    . PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../../../../zendframework/library')
    . PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../../../../phpexcel')
	. PATH_SEPARATOR . get_include_path()
);

// FUNCTIONS LIKE F_DBG FOR DEBUGING
include_once 'F/Technical/functions.php';

// AUTOLOAD
require_once 'F/Technical/Loader/Service.php';
\F\Technical\Loader\Service::singleton()->autoload();

// require_once 'F/Technical/Loader/Service.php';
// \F\Technical\Loader\Service::singleton()->autoload();

// DATABASE
$bdd = array(
    'host'     => '127.0.0.1',
    'username' => 'feelpix',
    'password' => 'feelpix',
    'dbname' => 'f_test'
);
require_once '\F\Technical\Registry\Service.php';
\F\Technical\Registry\Service::singleton()->setProperty('bdd', $bdd);