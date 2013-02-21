<?php

class Application_Model_DeleteAuthAssertion implements Zend_Acl_Assert_Interface {

    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $user = null,
                          Zend_Acl_Resource_Interface $delete = null, $privilege = null) {
        //echo Zend_Registry::get('role');
        if(Zend_Registry::get('role') == 'administrators'){
            return false;
        }
//     echo 'user'.var_dump($user->user_id)."<br />";
//        echo 'comment'. var_dump($comment->owner_id)."<br />";
//        //die();
        if($user->user_id == $delete->owner_id){
            //echo "true";
            return true;
        } else {
            //echo "false";
            return false;
        }
    }


}


