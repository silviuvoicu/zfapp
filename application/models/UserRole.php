<?php

class Application_Model_UserRole implements Zend_Acl_Role_Interface
{
    public $role = null;
    public $user_id = null;

    public function __construct(){
        $this->user_id = Zend_Auth::getInstance()->getIdentity()->id;
        $this->role = (Zend_Auth::getInstance()->hasIdentity())?Zend_Auth::getInstance()->getIdentity()->role:'guest';
    }
    public function getUserId(){
        //echo "from getUserID method";
        return $this->user_id;
    }
    public function getRoleId(){
        return $this->role;
    }
}


