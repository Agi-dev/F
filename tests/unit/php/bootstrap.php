<?php
set_include_path(
    realpath(dirname(__FILE__) . '/../../../sources')
    . PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../../../../phpexcel')
    . PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../../../../zendframework/library')
	. PATH_SEPARATOR . get_include_path()
);

// functions like f_dbg for debuging
include_once 'F/Technical/functions.php';

// Starting session
require_once 'Zend/Session.php';
\Zend_Session::start();

// require_once 'F/Technical/Translate/Service.php';
// \F\Technical\Translate\Service::singleton()->setCurrentLocale('fr_FR.utf8');