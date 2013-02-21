<?php

// Define path to application directory
//defined('APPLICATION_PATH')|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

define('DS', DIRECTORY_SEPARATOR);
define('ZEND_LIBRARY_PATH', realpath('C:\\zend\\library\\'));
define('APPLICATION_PATH', 'C:'.DS.'cdcollection'.DS.'application' );
define('APP_LIBRARY_PATH', APPLICATION_PATH . DS.'..\library');
//define('ZENDX_LIBRARY_PATH', realpath('C:\\zend\\library\\ZendX\\'));
//echo APPLICATION_PATH;
//die();
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    ZEND_LIBRARY_PATH,
   APPLICATION_PATH,
    realpath(APPLICATION_PATH . '/views/scripts'),
    //realpath(APPLICATION_PATH . '/../library'),
    APP_LIBRARY_PATH,
    
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require_once ( APP_LIBRARY_PATH . DS . 'Utils.php');    

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH .DS.  'configs' . DS . 'application.ini'
);
$application->bootstrap()
            ->run();