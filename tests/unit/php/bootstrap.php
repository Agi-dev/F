<?php
set_include_path(
    realpath(dirname(__FILE__) . '/../../../sources')
	. PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../../../../zendframework/library')
	. PATH_SEPARATOR . get_include_path()
);
include_once 'F/Technical/functions.php';
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();