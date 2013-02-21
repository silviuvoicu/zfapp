<?php

class Application_Model_EditAssertion  implements Zend_Acl_Assert_Interface {

    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $user = null,
                          Zend_Acl_Resource_Interface $edit = null, $privilege = null) {
        //echo Zend_Registry::get('role');
        if(Zend_Registry::get('role') == 'administrators'){
            return true;
        }
//     echo 'user'.var_dump($user->user_id)."<br />";
//        echo 'edit'. var_dump($edit->owner_id)."<br />";
//        var_dump($user->user_id == $edit->owner_id);
        if($user->user_id == $edit->owner_id){
          //  echo "true";
            return true;
        } else {
            //echo "false";
            return false;
        }
    }


}



