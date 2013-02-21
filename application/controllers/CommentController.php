<?php

class CommentController extends Zend_Controller_Action
{

    public function init()
    {
         $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContexts(array( 'add' => 'json', 'edit' => 'json'))

                //->addActionContext('list', 'json')
                ->initContext();
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $idCd =(int) $this->_getParam('idCd', 0);
         $form = new Application_Form_Comment();
        $form->submit->setLabel('Add');
        $form->submit->setName('add');
        $request = $this->getRequest();
        $session = new Zend_Session_Namespace('Application');
       
        if (!$request->isXmlHttpRequest()) {
            $album = new Application_Model_DbTable_Albums();
            $albuminfo = $album->getAlbum($idCd);
            $this->view->albumtitle = $albuminfo['titel'];
            $form->cd_id->setValue($idCd);
            $this->view->form = $form;
            if ($request->isPost()) {
                $formData = $request->getPost();
                if ($form->isValid($formData)) {
                    $comment = $form->getValue('comment');
                    
                    $userRole = new Application_Model_UserRole();
                    $user_id = $userRole->getUserId();
                    $cd_id = (int) $form->getValue('cd_id');
                    
                    $comments = new Application_Model_DbTable_Comments();
                    $comments->addComment($comment, $cd_id,  $user_id);
                   // $session = new Zend_Session_Namespace('Application');
                    
                    $session->newComment = $cd_id;
                     $redirect = $session->redirect;
       
                    $pos = strpos($redirect, '/secondpage');
                    if ($pos){
                        $newredirect =substr_replace( $redirect, '', $pos);
                        $session->currentSecondPage[$cd_id]= 1;
                        $session->redirect = $newredirect;
//                         var_dump($newredirect);      
//                                die();
                    }
                    
//                    echo $session->redirect;
//                    die();
                     $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                  //  $this->_helper->redirector('index','index');
                } else {
                    $form->populate($formData);
                }
            }
        } if ($request->isXmlHttpRequest()) {
            //$data=$form->processAjax($_POST);
//                 var_dump($_POST);
//                 var_dump($data);
//                 die;
            // echo $data;
            //  $this->_helper->json($data);
//                 var_dump($request->getPost());
//                 die;
            //  var_dump($request->getPost());die;

            $data = $form->isValid($request->getPost());
            //var_dump($data);
            // $this->getResponse()->setHeader('Content-type','application/json')->setBody($data);
////             var_dump($this->_getAllParams());
//
////             die;
            if (!$data) {
                $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                $this->_helper->json($json);
            }else{
                 $this->view->ok ='ok';
            }
        }
    }

    public function editAction()
    {
        $id = (int) $this->_getParam('id', 0);
       // $idCd =(int) $this->_getParam('idCd', 0);
        //  if ($id > 0) {
        $comments = new Application_Model_DbTable_Comments();
        $userRole = new Application_Model_UserRole();
        $commentResource = new Application_Model_CommentEditResource();
        $session = new Zend_Session_Namespace('Application');
        $comment = $comments->getComment($id);
       
        $commentResource->owner_id = $comment['user_id'];
        $request = $this->getRequest();  
        if (Zend_Registry::get('acl')->isAllowed($userRole, $commentResource, 'edit')) {
            $form = new Application_Form_Comment();
            $form->submit->setLabel('Save');
             $form->submit->setName('save');
             
             if (!$request->isXmlHttpRequest()) {
           
            if ($request->isPost()) {
                $formData = $request->getPost();
                if ($form->isValid($formData)) {
                    $id = (int) $form->getValue('comment_id');
                    $comment = $form->getValue('comment');
                    $cd_id= (int)$form->getValue('cd_id');
                   
                   // $comments = new Application_Model_DbTable_Comments();
                   $comments->updateComment($id, $comment);
                  //  $session = new Zend_Session_Namespace('Application');

                $session->editComment = $cd_id;  
               $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                  //  $this->_helper->redirector('index','index');
                } else {
                    $form->populate($formData);
                }
            } else {
              //  $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    // $albums = new Application_Model_DbTable_Albums();
                    // $userRole = new Application_Model_UserRole();
                    //   $editResource = new Application_Model_EditResource();
                    //var_dump($comment);
                   // $album = $albums->getAlbum($id);
                    //  $editResource->owner_id = $album['user_id'];
                    // if (Zend_Registry::get('acl')->isAllowed($userRole, $editResource, 'edit')) {
                    //var_dump($comment);
//                    foreach($comment as $key => $value){
//                        
//                        if ($key != 'comment') {
//                           // echo $key;
//                            continue;
//                        }
//                        else{
//                            $key = 'commentText';
//                           // echo $key;
//                            unset($comment['comment']);
//                            $comment[$key]=$value;
//                        }
                //    }
                  //  var_dump($comment);
                   $form->populate($comment);
                    $this->view->form = $form;
                    // }
                }
            }
            } if ($request->isXmlHttpRequest()) {
            //$data=$form->processAjax($_POST);
//                 var_dump($_POST);
//                 var_dump($data);
//                 die;
            // echo $data;
            //  $this->_helper->json($data);
//                 var_dump($request->getPost());
//                 die;
            //  var_dump($request->getPost());die;

            $data = $form->isValid($request->getPost());
            //var_dump($data);
            // $this->getResponse()->setHeader('Content-type','application/json')->setBody($data);
////             var_dump($this->_getAllParams());
//
////             die;
            if (!$data) {
                $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                $this->_helper->json($json);
            }else{
                 $this->view->ok ='ok';
            }
        }
        } else {
           // $request = $this->getRequest();
//                var_dump( Zend_Controller_Front::getInstance()->getRequest());
//                  $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
//        $session = new Zend_Session_Namespace('Application');
//        $session->redirect = $url;
            $request->setControllerName('error')
                    ->setActionName('denied');
        }
    }

    public function deleteAction()
    {
         $id = $this->_getParam('id', 0);
        //  if ($id > 0) {
        $comments = new Application_Model_DbTable_Comments();
        $userRole = new Application_Model_UserRole();
        $commentResource = new Application_Model_CommentDeleteResource();
        $session = new Zend_Session_Namespace('Application');
        $request = $this->getRequest();
        $comment = $comments->getComment($id);
        $commentResource->owner_id = $comment['user_id'];

        if (Zend_Registry::get('acl')->isAllowed($userRole, $commentResource, 'delete')) {
            if ($request->isPost()) {
                $del = $request->getPost('del');
                if ($del == 'Yes') {
                    $id = $request->getPost('id');
                    $cd_id = $request->getPost('cd_id');
                   // $albums = new Application_Model_DbTable_Albums();
                    $comments->deleteComment($id);
                     $redirect = $session->redirect;
       
                    $pos = strpos($redirect, '/secondpage');
                    if ($pos){
                        $newredirect =substr_replace( $redirect, '', $pos);
                        $session->currentSecondPage[$cd_id]= 1;
                        $session->redirect = $newredirect;
//                         var_dump($newredirect);      
//                                die();
                    }
                    $session->deleteComment = $cd_id;
                    $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                }else{
                     $cd_id = $request->getPost('cd_id');
                    $session->deleteComment = $cd_id;
                    $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                }
               // $session = new Zend_Session_Namespace('Application');
//            echo urldecode($session->redirect);
//            die();
               // $this->_helper->redirector('index','index');
               // ); //, array('prependBase' => false));
            } else {
                // $id = $this->_getParam('id', 0);
                //echo $id;
                $albums = new Application_Model_DbTable_Albums();
                $this->view->cd_id = $comment['cd_id'];
                $this->view->id = $comment['comment_id'];
                $this->view->album = $albums->getAlbum($comment['cd_id']);
            }
        } else {
            
//                var_dump( Zend_Controller_Front::getInstance()->getRequest());
//                  $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
//        $session = new Zend_Session_Namespace('Application');
//        $session->redirect = $url;
            $request->setControllerName('error')
                    ->setActionName('denied');
        }
    }


}







