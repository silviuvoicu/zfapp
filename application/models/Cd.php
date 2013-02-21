<?php

class Application_Model_Cd
{
    private $id = null;
    private $titel = null;
    private $interpret = null;
    private $jahr = null;
    private $userCd = null;
    private $comments = array();

    public function  __construct($id) {
        $this->id = $id;
    }
     public function getId() {
        return $this->id;
    }
    public function addTitel($titel){
        $this->titel = $titel;
    }

    public function addInterpret($interpret){
        $this->interpret = $interpret;
    }
    public function addJahr($jahr){
        $this->jahr = $jahr;
    }
     public function addUserId($userCd){
        $this->userCd = $userCd;
    }
    public function addComments($comments){
        $this->comments = $comments;
    }

    public function getTitel() {
        return $this->titel;
    }

    public function getInterpret() {
        return $this->interpret;
    }
     public function getJahr() {
        return $this->jahr;
    }
     public function getUserId() {
        return $this->userCd;
    }
    
    public function getComments($url){
      //  var_dump($url);
//        die();
        $comments = '';
    //     var_dump($comments);  
//        die();
        $userRole = new Application_Model_UserRole();
    //    var_dump($userRole);
//        die();
     //   var_dump($this->comments);
       // die();
        $commentEditResource = new Application_Model_CommentEditResource();
        $commentDeleteResource = new Application_Model_CommentDeleteResource();
    // var_dump($commentResource);
     //die();
//        var_dump($comments);  
//        die();
      //  $userRole = new Application_Model_UserRole();
if (Zend_Registry::get('acl')->isAllowed($userRole, 'comment', 'add')){
   
   
        $comments .='<p><a href="'. $url.'add/idCd/'.$this->getId() .'">Add new comment</a></p>';
        }
        if(count($this->comments)){
            $comments .='Comments: ';
        foreach($this->comments as $id => $comment){
           // var_dump($comment);
            $commentEditResource->owner_id = $comment['user_id'];
             $commentDeleteResource->owner_id = $comment['user_id'];
//            echo 'Zend_Registry::get(acl)'.Zend_Registry::get('acl');
//            die();
             
           if(Zend_Registry::get('acl')->isAllowed($userRole, $commentEditResource, 'edit')){
//                echo $userRole->getUserId()."<br />";
//                echo  $commentResource->getOwnerId();
                $this->comments[$id]['comment'] .= ' <a href="'.$url.'edit/id/'.$comment['comment_id'].'">Edit</a> ';
               
            }
            if(Zend_Registry::get('acl')->isAllowed($userRole, $commentDeleteResource, 'delete')){
//                echo $userRole->getUserId()."<br />";
//                echo  $commentResource->getOwnerId();
               $this->comments[$id]['comment'] .= ' <a href="'.$url.'delete/id/'.$comment['comment_id'].'">Delete</a> ';
               
            }
            $comments .= ' <dl><dt>'. $this->comments[$id]['comment'].'</dt>';
            $comments .= '<dd>'. $this->comments[$id]['username'].'</dd></dl>';
        }
        //$commnets .= ' <dl><dt>'. $this->comments[$id]['comment'].'</dt>';
        }
//         var_dump($commentResource);
//        die();
        return $comments;
    }
   public function getEditLinks($url){
       $editLink = '';
       $userRole = new Application_Model_UserRole();
       $editResource = new Application_Model_EditResource();
//         var_dump($editResource);
//        die(); 
    $editResource->owner_id = $this->getUserId();
//     var_dump($editResource);
//        die();
//      var_dump($this->_acl->isAllowed('users', 'index:edit', 'edit'));
//        die();
     if (Zend_Registry::get('acl')->isAllowed($userRole, $editResource, 'edit')) {
        $editLink = '<a href="' . $url . '">Edit</a>';
        
    }
     return $editLink;
   
   }
    
    public function getDeleteLinks($url){
        $deleteLink = '';
        $userRole = new Application_Model_UserRole();
       $deleteResource = new Application_Model_DeleteResource();
    $deleteResource->owner_id = $this->getUserId();
      if (Zend_Registry::get('acl')->isAllowed($userRole, $deleteResource, 'delete')) {
        $deleteLink = '<a href="' . $url . '">Delete</a>';
    }
    return $deleteLink;
   }


}

