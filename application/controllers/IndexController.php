<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContexts(array('list' => 'json', 'add' => 'json', 'edit' => 'json'))

                //->addActionContext('list', 'json')
                ->initContext();
    }

    public function indexAction() {
        /* $controller = Zend_Registry::get('controller'); 
          $action = Zend_Registry::get('action');
          echo $controller."<br />";
          echo $action; */
//        Zend_Debug::dump($this->_getAllParams());
//die();
        $this->_forward('list','index');
    }

    public function addAction() {
        $form = new Application_Form_Album();
        $form->submit->setLabel('Add');
        $form->submit->setName('add');
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            
            if ($request->isPost()) {
              //  $formData = $request->getPost();
               // var_dump($formData);
               // die;
                if ($form->isValid( $request->getPost())) {
                    $artist = $form->getValue('interpret');
                    $title = $form->getValue('titel');
                    $year = $form->getValue('jahr');
                    $userRole = new Application_Model_UserRole();
                    $user_id = $userRole->getUserId();
                    $albums = new Application_Model_DbTable_Albums();
                    $albums->addAlbum($artist, $title, $year, $user_id);
                   // $session = new Zend_Session_Namespace('Application');


                    // $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                    $this->_helper->redirector('index');
                } else {
//                     var_dump($formData);
//                     die;
                    $this->view->form = $form;
                   // $form->populate($formData);
                }
            }else{
                $this->view->form = $form;
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
          //    var_dump($request->getPost());
              //die;

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

    public function editAction() {
        $id = $this->_getParam('id', 0);
        //  if ($id > 0) {
        $albums = new Application_Model_DbTable_Albums();
        $userRole = new Application_Model_UserRole();
        $editResource = new Application_Model_EditResource();
        $session = new Zend_Session_Namespace('Application');
//        $url = $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
//        $session->redirect = $url;

        $album = $albums->getAlbum($id);
        $editResource->owner_id = $album['user_id'];
        $request = $this->getRequest();  
        if (Zend_Registry::get('acl')->isAllowed($userRole, $editResource, 'edit')) {
            $form = new Application_Form_Album();
            $form->submit->setLabel('Save');
             $form->submit->setName('save');
             
             if (!$request->isXmlHttpRequest()) {
            $this->view->form = $form;
            if ($request->isPost()) {
                $formData = $request->getPost();
                if ($form->isValid($formData)) {
                    $id = (int) $form->getValue('id');
                    $artist = $form->getValue('interpret');
                    $title = $form->getValue('titel');
                    $year = $form->getValue('jahr');
                    $albums = new Application_Model_DbTable_Albums();
                    $albums->updateAlbum($id, $artist, $title, $year);
                    $session->editId = $id;

//                echo $session->redirect;  
                   // $this->_forward($session->redirect);
                $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                   // $this->_helper->redirector('index');
                } else {
                    $form->populate($formData);
                }
            } else {
              //  $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    // $albums = new Application_Model_DbTable_Albums();
                    // $userRole = new Application_Model_UserRole();
                    //   $editResource = new Application_Model_EditResource();

                   // $album = $albums->getAlbum($id);
                    //  $editResource->owner_id = $album['user_id'];
                    // if (Zend_Registry::get('acl')->isAllowed($userRole, $editResource, 'edit')) {

                    $form->populate($album);
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
        //  }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        //  if ($id > 0) {
        $albums = new Application_Model_DbTable_Albums();
        $userRole = new Application_Model_UserRole();
        $deleteResource = new Application_Model_DeleteResource();
         $session = new Zend_Session_Namespace('Application');
        $request = $this->getRequest();
        $album = $albums->getAlbum($id);
        $deleteResource->owner_id = $album['user_id'];

        if (Zend_Registry::get('acl')->isAllowed($userRole, $deleteResource, 'delete')) {
            if ($request->isPost()) {
                $del = $request->getPost('del');
                if ($del == 'Yes') {
                    $id = $request->getPost('id');
                    $albums = new Application_Model_DbTable_Albums();
                    $albums->deleteAlbum($id);
                    $this->_helper->redirector('index');
                }else{
                    $id = $request->getPost('id');
                    $session->deleteId = $id;
                    $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
                }
               // $session = new Zend_Session_Namespace('Application');
//            echo urldecode($session->redirect);
//            die();
               
               // $this->_helper->redirector->gotoUrl(urldecode($session->redirect)); //, array('prependBase' => false));
            } else {
                // $id = $this->_getParam('id', 0);
                //echo $id;
                $albums = new Application_Model_DbTable_Albums();
                $this->view->album = $albums->getAlbum($id);
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

    public function listAction() {
//        $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
       $session = new Zend_Session_Namespace('Application');
//        $session->redirect = $url;
       
        $cdsList = new Application_Model_ListCds();
        $cds = $cdsList->listCds($this->_getParam('page', (isset($session->currentPage) ? $session->currentPage :1)), $this->_getParam('secondpage', 1), $this->_getParam('idCd')); //,
        $editLink = array();
        $deleteLink = array();
        $details = array();
        $paginator3 = array();
        $currentPage = array();
        $pagesPaginators = array();
        $urlSecondPages = array();
       
        $paginator2 = array_shift($cds);
   
        foreach ($cds as $i => $cd) {
                       $details[$i] = $cd->getComments($this->_helper->url('', 'comment', null));
                        $idCd[$i] = $cd->getId();
            $params = array('idCd' => $idCd[$i]);
            $editLink[$i] = $cd->getEditLinks($this->_helper->url('edit', null, null, array('id' => $cd->getId()))); //. '">Edit</a>';
            $deleteLink[$i] = $cd->getDeleteLinks($this->_helper->url('delete', null, null, array('id' => $cd->getId()))); //. '">Delete</a>';
           
            $pages[$i] = $paginator2[$i]->getPages();
            if ($pages[$i]->pageCount != 0) {
                $pagesPaginators[$i] = $paginator2[$i]->getPages();
                $currentPage[$i] = $paginator2[$i]->getCurrentPageNumber();
            }
          
            $session->currentSecondPage[$idCd[$i]] = $currentPage[$i];
            $paginator3[$i] = Zend_View_Helper_PaginationControl::paginationControl($paginator2[$i], 'Sliding', 'pagination2.phtml', $params);
           
        }
     
         $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        $this->view->cds = $cds; //array;
        $this->view->editLink = $editLink;
        $this->view->deleteLink = $deleteLink;
        $this->view->details = $details;
        $this->view->paginator2 = $paginator3;
        // $this->view->idCd =$idCd;
        $this->view->currentPage2 = $currentPage;
        $this->view->url = $this->_helper->url('index', null, null, array('page' => ''));
       
        if (!$this->_request->isXmlHttpRequest()) {
            // var_dump($cdsList->getPaginator());
            $this->view->paginator = $cdsList->getPaginator();

           
        } else {
            $this->view->currentPage = $cdsList->getPaginator()->getCurrentPageNumber();
            $session->currentPage = $cdsList->getPaginator()->getCurrentPageNumber();
            $this->view->pagesPaginators = $pagesPaginators;
            $this->view->pages = $cdsList->getPaginator()->getPages();
            // $this->view->cds = $cds;
            $this->view->cds = json_decode($cdsList->getPaginator()->toJson());
            $session->idCdUrl = $this->_getParam('idCd');
            $this->view->idCdUrl = $this->_getParam('idCd');
           
        }

        
    }

}

