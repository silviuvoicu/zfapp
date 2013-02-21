<?php

class Application_Model_ProfileAssertion implements Zend_Acl_Assert_Interface {

    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $user = null,
                          Zend_Acl_Resource_Interface $userprofile = null, $privilege = null) {
        
        if(Zend_Registry::get('role') == 'administrators'){
            return true;
        }

        if($user->user_id == $userprofile->owner_id){
          
            return true;
        } else {
            
            return false;
        }
    }
}

