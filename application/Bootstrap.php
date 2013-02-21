<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    private $_acl = null;

    protected function _initAutoload() {
        $modelLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => APPLICATION_PATH));

    

        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Registry::set('role', Zend_Auth::getInstance()->getStorage()->read()->role);
        } else {
            Zend_Registry::set('role', 'guest');
        }

        $this->_acl = new Application_Model_LibraryAcl();
        $this->_auth = Zend_Auth::getInstance();

        $fc = Zend_Controller_Front::getInstance();
       
        $fc->registerPlugin(new Plugin_AccessCheck($this->_acl));
         Zend_Registry::set('acl', $this->_acl);

        //return $modelLoader;
    }
    #stores a copy of the config object in the Registry for future references
	#!IMPORTANT: Must be runed before any other inits
	protected function _initConfig()
    {
    	Zend_Registry::set('config', new Zend_Config($this->getOptions()));
    }

 #initializes the DEBUG constant to true or false based on config. settings and/or cookie
    #and stores a copy of the Zend_Logger in the Registry for future references
 	protected function _initDebug()
    {
    	$config = Zend_Registry::get('config');

    	if (isset($config->settings->debug->enabled))
    	{
    		if ($config->settings->debug->enabled == TRUE)
    		{
    			define('DEBUG', TRUE);
    		}
    		else
    		{
    			if (isset($config->settings->debug->cookie))
    			{
    				$debug_cookie = $config->settings->debug->cookie;

    				if (array_key_exists($debug_cookie,$_COOKIE))
    				{
    					define('DEBUG', TRUE);
    				}
    			}
    		}
    	}

    	if (FALSE === defined('DEBUG'))
    	{
    		define('DEBUG', FALSE);
    	}

    	$logger = new Zend_Log();
		$writer = new Zend_Log_Writer_Firebug();
		$logger->addWriter($writer);
        
		Zend_Registry::set('logger', $logger);
    } 
    public function _initDbAdapter()

    {

        $this->bootstrap('db'); 
        $dbAdapter = $this->getResource('db'); 
        Zend_Registry::set('dbAdapter', $dbAdapter); 
         $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
$profiler->setEnabled(true);       
// Attach the profiler to your db adapter
Zend_Registry::get('dbAdapter')->setProfiler($profiler);

    } 
    protected function _initZFDebug()
    {
        if (!DEBUG)
		{
			return FALSE;
		}
       $config = Zend_Registry::get('config');
	    $options = array(
	        
       //'jquery_path' => 'C:\cdcollection\public\js\jquery\js\jquery-1.6.2.min.js',
       'plugins' => array('Variables',
	    		 'ZFDebug_Controller_Plugin_Debug_Plugin_Debug' => array('tab'   => 'Debug', 'panel' => ''),
                       'ZFDebug_Controller_Plugin_Debug_Plugin_Auth',
	            //'Database' => array(Zend_Db_Table::getDefaultAdapter()), 
                    'File' => array('basePath' => realpath(APPLICATION_PATH )),
                           'Memory',
                           'Time', 
	                           'Registry',
	                           'Exception')
	    );
//            
//        }
	    # Setup the cache plugin
	    if (Zend_Registry::isRegistered('cache'))
	    {
	        $cache = Zend_Registry::get('cache');
	        $options['plugins']['Cache']['backend'] = $cache->getBackend();
	    }
           
	    # Setup the databases
	    //$resource = $this->getPluginResource('db');
//            if(Zend_Registry::isRegistered('db')){
//                $db = Zend_Registry::get('db')->getDbAdapter();
//                $options['plugins']['Database']['adapter'] = $db;
//            }
//	    
      //  var_dump($options);
	    # Init the ZF Debug Plugin
	    $debug = new ZFDebug_Controller_Plugin_Debug(
                   // array('jquery_path' => 'C:\cdcollection\public\js\jquery\js\jquery-1.6.2.min.js',
                        $options);
        //);
            //$debug->registerPlugin(new ZFDebug_Controller_Plugin_Debug_Plugin_Database($db));
             $debug->registerPlugin(new ZFDebug_Controller_Plugin_Debug_Plugin_Database()); 
	    $this->bootstrap('frontController');
	    $frontController = $this->getResource('frontController');
	    $frontController->registerPlugin($debug);
	
//       
    }
protected function _initZFirebug()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('ZFirebug');

		$options = array(
        'plugins' => array("Variables",
							'File',
							'Html',
							'Memory', 
							'Time', 
							'Registry', 
							'Auth')
		);

		$debug = new ZFirebug_Controller_Plugin_Debug($options);

		$this->bootstrap('frontController');
		$frontController = $this->getResource('frontController');
		$frontController->registerPlugin($debug);

	}

    
protected function _initView()
   {
       $view = new Zend_View();
       return $view;
   }
    function _initViewHelpers() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
       $view->setHelperPath(APPLICATION_PATH.'/views//helpers', '');

    // $view->addHelperPath(APPLICATION_PATH .'/views/helpers/' , 'View_Helper');
    // $view->addHelperPath('/library/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper_JQuery');
//     $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
//'ViewRenderer'
//);
//$viewRenderer->setView($view);
//    //$view->addHelperPath('library/ZendX/Jquery','View_Helper' );
       ZendX_JQuery::enableView($view);
     $view->jQuery();


        //$view->loggedInAs();
        /*$view->doctype('HTML4_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-type', 'text/html;charset=utf-8')
                ->appendName('description', 'Using view helpers in Zend_view');

        $view->headTitle()->setSeparator(' - ')
                ->headTitle('Zend Framework Tutorial');
        */      
        $navContainerConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $navContainer = new Zend_Navigation($navContainerConfig);

        $view->navigation($navContainer)->setAcl($this->_acl)->setRole(Zend_Registry::get('role'));
    }

}

