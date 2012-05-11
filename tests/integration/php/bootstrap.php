<?php
set_include_path(
    realpath(dirname(__FILE__) . '/../../../sources')
	. PATH_SEPARATOR . get_include_path()
);

// functions like f_dbg for debuging
include_once 'F/Technical/functions.php';

// autoload
require_once 'F/Technical/Loader/Service.php';
\F\Technical\Loader\Service::singleton()->autoload( array("F" => "sources/F"));

// AFAIRE: utiler f config service
// indique le répertoire des jeu de données pour les ti
//\Zend_Registry::set('dataSetPath', realpath(dirname(__FILE__) . '/dataset'));
