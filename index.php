<?php

//require 'libs/config.php';
//require 'utils/Auth.php';
//require 'utils/formvalidator.php';
//require 'utils/Zebra_Pagination.php';
//require 'utils/calendar.php';

define('KAPALIGIRAN', 'pagsasagawa');

if (defined('KAPALIGIRAN'))
{
	switch (KAPALIGIRAN)
	{
		case 'pagsasagawa':
			error_reporting(E_ALL);
		break;
	
		case 'pagsusulit':
		case 'pagpinale':
			error_reporting(0);
		break;

		default:
			exit('The Easter Island environment is not set correctly.');
	}
}

//System Paths
define('LIBS', 'libs/');
define('UTILS', 'utils/');
define('APP_PATH', 'app/');
define('APP_PATH_CONTROLLER', APP_PATH.'controllers/');
define('APP_PATH_MODEL', APP_PATH.'models/');
define('APP_PATH_VIEW', APP_PATH.'views/');
define('APP_PATH_FUNCTION', APP_PATH.'functions/');
define('APP_PATH_CONFIG', APP_PATH.'config/');


//Default Controllers
//Note: Do not use INDEX as your main controller
$default_contoller = "main";
$default_error_controller = "error";

// Load the Bootstrap!
require LIBS.'Bootstrap.php';
$bootstrap = new Bootstrap();
// Optional Path Settings
$bootstrap->setControllerPath(APP_PATH_CONTROLLER);
$bootstrap->setModelPath(APP_PATH_MODEL);
$bootstrap->setDefaultFile($default_contoller);
$bootstrap->setErrorFile($default_error_controller);

//Let the Easter Island Begin!!!
$bootstrap->init();