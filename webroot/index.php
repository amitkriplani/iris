<?php
// Web root path
defined ( 'WEB_ROOT' ) || define ( 'WEB_ROOT', realpath ( dirname ( __FILE__ ) ) );

// App root path
defined ( 'APP_ROOT' ) || define ( 'APP_ROOT', realpath ( WEB_ROOT . '/../app' ) );

// Add app root to iinclude path
set_include_path ( implode ( PATH_SEPARATOR, array (
		APP_ROOT,
		get_include_path () 
) ) );

// include iris application
require_once 'Iris.php';

// run iris application
$iris = new Iris ();
$iris->setup ( getenv ( 'mode' ) )->run ();

