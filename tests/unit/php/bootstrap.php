<?php
set_include_path(
    realpath(dirname(__FILE__) . '/../../../sources')
        . PATH_SEPARATOR . get_include_path()
);

// functions like f_dbg for debuging
include_once 'F/Technical/functions.php';