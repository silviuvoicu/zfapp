<?php

class Application_Model_LibraryAcl extends Zend_Acl {

    public function __construct() {
        //$this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('error'));
  
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('index:edit'), 'index');
        $this->add(new Zend_Acl_Resource('index:delete'), 'index');
          $this->add(new Zend_Acl_Resource('comment'));
        $this->add(new Zend_Acl_Resource('comment:edit'),'comment');
        $this->add(new Zend_Acl_Resource('comment:delete'),'comment');
       //  $this->add(new Zend_Acl_Resource('add'), 'index');
        /* $this->add(new Zend_Acl_Resource('list'),'index');
          
         
         
*/

        $this->add(new Zend_Acl_Resource('auth'));
        $this->add(new Zend_Acl_Resource('auth:password'), 'auth');
        $this->add(new Zend_Acl_Resource('auth:profile'), 'auth');
        $this->add(new Zend_Acl_Resource('auth:delete'),'auth');
        
        $this->add(new Zend_Acl_Resource('fbkcdcollection'));





        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('users'), 'guest');
        $this->addRole(new Zend_Acl_Role('administrators'), 'users');
        
        
         $this->allow('guest','fbkcdcollection');
        $this->allow('guest', 'auth', 'login');
        $this->allow('guest','auth','register');
        $this->allow('guest','auth','lost');
        $this->allow('guest','auth','recover');
        $this->allow('guest','auth','confirm');
         $this->allow('guest', 'index', 'index');
        $this->allow('guest', 'index', 'list');
        $this->allow('guest', 'error');
        $this->allow('users', 'auth');


        $this->deny('users', 'auth', 'login');
        $this->deny('users', 'auth', 'register');
        $this->deny('users', 'auth', 'lost');
        $this->deny('users', 'auth', 'recover');
         $this->allow('users', 'index', 'add'); 
         $this->allow('users','comment','add');
//         $this->allow('users','index:edit','edit', new Application_Model_EditAssertion());
//         $this->allow('users','index:delete','delete', new Application_Model_DeleteAssertion());
//          $this->allow('users','comment:edit', 'edit', new Application_Model_CommentAssertion());
//
//if(!$this->has('comment')){  
//        $this->addResource('comment');
//       }
//        $this->allow('users', 'comment', 'edit', new Application_Model_CommentAssertion());
        //}
        $this->allow('administrators');
        $this->deny('administrators','auth','delete');
    } 
    
      public function setDynamicPermissions() {
           $this->allow('users','index:edit','edit', new Application_Model_EditAssertion());
         $this->allow('users','index:delete','delete', new Application_Model_DeleteAssertion());
          $this->allow('users','comment:edit', 'edit', new Application_Model_CommentAssertion());
           $this->allow('users','comment:delete', 'delete', new Application_Model_CommentAssertion());
            $this->allow('users','auth:password', 'password', new Application_Model_PasswordAssertion());
             $this->allow('users','auth:profile', 'profile', new Application_Model_ProfileAssertion());
              $this->allow('users','auth:delete','delete', new Application_Model_DeleteAuthAssertion());
             //  $this->deny('administrators','auth','delete');
      // if(!$this->has('comment')){  
        //$this->addResource('comment');
       //}
       // $this->allow('users', 'comment', 'edit', new Application_Model_CommentAssertion());
        //}
    }
//   public function __toString() {
//       return " Application_Model_LibraryAcl";
//   }

}

