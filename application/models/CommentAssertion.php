<?php

class Application_Model_CommentAssertion implements Zend_Acl_Assert_Interface {

    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $user = null,
                          Zend_Acl_Resource_Interface $comment = null, $privilege = null) {
        
        if(Zend_Registry::get('role') == 'administrators'){
            return true;
        }

        if($user->user_id == $comment->owner_id){
          
            return true;
        } else {
            
            return false;
        }
    }


}
