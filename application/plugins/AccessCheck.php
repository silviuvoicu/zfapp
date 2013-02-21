<?php
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
    
    private $_acl = null;
    
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
      
        
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $resource = $request->getControllerName();
        $action = $request->getActionName();
        $actions = array('edit','delete','password','profile');
        if(in_array($action,$actions)){
            
        $resource="$resource:$action";
        }
//        Zend_Registry::set('controller',$resource);
//        Zend_Registry::set('action',$action);
        /*echo $resource."<br />";
        echo $action."<br />";
        echo 'role '.Zend_Registry::get('role');
       die();
         
     
       /*
      echo $controller."<br />";
      echo $action;
        die();
         * 
         */
        $this->_acl->setDynamicPermissions();
        //echo $this->_acl;
//        $reflectionClass = new ReflectionClass($this->_acl);
//var_dump($reflectionClass->getMethods());
   //   var_dump($this->_acl);
//        echo "role ".Zend_Registry::get('role')."</br>";
//        echo "resource ".$resource."</br>";
//        echo "action ".$action."</br>";
//        var_dump(!$this->_acl->isAllowed(Zend_Registry::get('role'), $resource, $action));
//        die;
        if(!$this->_acl->isAllowed(Zend_Registry::get('role'), $resource, $action)){
            if(($resource == 'index') && ($action =='index')){
            $request->setControllerName('index')
                    ->setActionName('list');
            
        }
            else{
                //  
                  
        //echo  $this->_acl;
                 $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $session = new Zend_Session_Namespace('Application');
        $session->redirect = $url;
                $request->setControllerName('error')
                    ->setActionName('denied');
                
            }  
        }    

       
        
        
    }
}
