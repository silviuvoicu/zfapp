<?php

class AuthController extends Zend_Controller_Action {

    public function init() {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContexts(array('_process' => 'json', 'login' => 'json', 'register' => 'json',
                    'lost' => 'json', 'password' => 'json', 'profile' => 'json'))
                ->initContext();
    }

    public function indexAction() {
        
    }

    protected function generetePass($length = 8) {
        // Define supported characters in the unique string
        $seeds = 'abcdefghijklmnopqrstuvwqyz0123456789';

        $code = '';

        $count = strlen($seeds);

        for ($i = 0; $i < $length; $i++) {
            $code .= $seeds[mt_rand(0, $count - 1)];
        }

        return $code;
    }

    protected function _process($values) {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();

//        var_dump($adapter);
//       // die();
        //if (($values['username']!='')  && ($values['username']!='')){
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);
//         $select = $adapter->getDbSelect();
//       $select->where('active = 1');
//        }else{
//             $this->view->errorMessage = "User name or password wrong";
//            return false;
//        }
        $request = $this->getRequest();
//         var_dump($request);
//         die;

        $auth = Zend_Auth::getInstance();
        //   if (!$request->isXmlHttpRequest()) {
        $result = $auth->authenticate($adapter);

//         echo $result->getIdentity();
//         die;
//     $user = $adapter->getResultRowObject(array('id', 'username', 'role','active'));
//     $auth->getStorage()->write($user);
////     var_dump($user);
//     die();
        // $auth->getStorage()->write($user);
        if ($result->isValid()) {
//$user = $adapter->getResultRowObject(array('id', 'username', 'role','active'));
            $user = $adapter->getResultRowObject(array('id', 'username', 'role', 'active'));
            $active = $user->active;

            if (!$request->isXmlHttpRequest()) {
                // if(!$this->_request->isXmlHttpRequest())

                if ($active == '1') {
                    $auth->getStorage()->write($user);
//             var_dump($user);
//             die();
//                if ($user->active === '1') {
                    //$auth->getStorage()->write($user);
//                    // for a long time remember me 
//                    // Zend_Session::rememberMe();
                    return true;
                } else {
                    $auth->clearIdentity();
                    $this->view->notActivated = "You have to activate your account first";
                    return false;
                }
            } else {
                if ($active == '1') {
                    $auth->clearIdentity();
                    $this->view->ok = 'ok';
                    return true;
                } else {
                    $auth->clearIdentity();
                    $this->view->notActivated = "You have to activate your account first";
                    return false;
                }
            }
        } else {
//            if($this->_request->isXmlHttpRequest()){
//                $errorMessage = "User name or password wrong";
//                $this->_helper->json($errorMessage);
//                //$this->view->errorMessage = "User name or password wrong";
//                
//            }
//            ;
//            $user = $adapter->getResultRowObject(array('id', 'username', 'role','active'));
//                 var_dump($user);
//                 die();
//            $auth->getStorage()->read();
//            var_dump( $auth->getStorage()->read());
//            die();

            $this->view->errorMessage = "User name or password wrong";
            return false;
        }
    }

    protected function _getAuthAdapter() {

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('SHA1(CONCAT(?,salt))');


        return $authAdapter;
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $session = new Zend_Session_Namespace('Application');
         unset($session->currentPage);
        unset($session->currentSecondPage);
        $this->_helper->redirector('index', 'index'); // back to login page redictor just index for the login page
        // index, index is for IndexController indexAction
    }

    public function loginAction() {
        $form = new Application_Form_Login();
        // ZendX_JQuery::enableForm($form);
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            if ($request->isPost()) {
                //  echo 'notajaxjson';
                //header('Content-type: application/json');
                // print_r($request->getPost());
                if ($form->isValid($request->getPost())) {
                    if ($this->_process($form->getValues())) {
                        // We're authenticated! Redirect to the home page
//                     $controller = Zend_Registry::get('controller'); 
//      $action = Zend_Registry::get('action');
//     echo $controller."<br />";
//      echo $action;
//      echo urldecode($session->redirect);
//      die();
                        $session = new Zend_Session_Namespace('Application');

//                        echo $session->redirect;
//                        die;
                        if(($session->redirect =='/auth/login/format/json')or ($session->redirect =='/auth/login')){
                                     $this->_helper->redirector('index', 'index');
                                }
//                        $redirect = explode("/",$session->redirect);
//                       $val = array_pop($redirect);
//                       $param = array_pop($redirect);
                     //   die;
                        if ($session->redirect != '/') {
                            // $session = new Zend_Session_Namespace('Application');


                            //if ($redirect[2]!='index'){
                            $this->_helper->redirector->gotoUrl(urldecode($session->redirect));
//                            }else{
//                                // $this->_redirect($url, $options)
//                                $this->_forward($redirect[1], $redirect[2],null , array($param=>$val));
//                               
//                            }
                            //
                        } else {
                            $this->_helper->redirector('index', 'index');
                        }
                    } else {
                        $this->view->form = $form;
                    }
                } else {
                    $this->view->form = $form;
                }


//    }else{
//            print_r($request->getPost());
//            $json = $form->processAjax($request->getPost());
//            $this->view->json =$json;
//            
//        } 
            } else {
                $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
                $this->view->form = $form;
            }
        }
        if ($request->isXmlHttpRequest()) {


            $data = $form->isValid($request->getPost());

            if (!$data) {

                $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                $this->_helper->json($json);
            } else {
                $this->_process($form->getValues());
            }
        }
    }

    public function registerAction() {
        // Instantiate the registration form model
        $form = new Application_Form_Register();


        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            // Has the form been submitted?
            if ($request->isPost()) {

                // If the form data is valid, process it
                if ($form->isValid($request->getPost())) {
                    //  if ($this->_register($form->getValues())) {
                    $user = new Application_Model_DbTable_Users();
                    $code = sha1(uniqid($form->getValue('username') . $form->getValue('email'), true));
                    $salt = Zend_Registry::get('config')->salt;
                    $password = sha1($form->getValue('password') . $salt);
                    $date_created = date('Y-m-d H:i:s');
                    //     try {
                    $user->addUser($form->getValue('username'), $form->getValue('email'), $code, $password, $salt, $date_created);
                    // Create a new mail object

                    $mail = new Zend_Mail();

                    // Set the e-mail from address, to address, and subject
                    $mail->setFrom(Zend_Registry::get('config')->email->support);
//              var_dump($user->getUserByUserName($form->getValue('username')));
//              die;
                    $mail->addTo($user->getUserByUserName($form->getValue('username'))->email, "{$user->getUserByUserName($form->getValue('username'))->username}");
                    $mail->setSubject('Album Registration Confirm Your Account');


                    // Retrieve the e-mail message text
                    include "_email_confirm_email_address.phtml";

                    // Set the e-mail message text
                    $mail->setBodyText($email);

                    // Send the e-mail
                    $mail->send();

                    // Set the flash message
                    $this->_helper->flashMessenger->addMessage(
                            Zend_Registry::get('config')->messages->register->successful
                    );

                    // Redirect the user to the home page
                    $this->_helper->redirector('login', 'auth');

//            } catch(Exception $e) {
//             $this->view->errorMessage = "There was a problem creating your account.";
//            }  	
                    //   }
                }
                // Does an account associated with this username already exist?
            }



            $this->view->form = $form;
        }

        if ($request->isXmlHttpRequest()) {


            $data = $form->isValid($request->getPost());

            if (!$data) {

                $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                $this->_helper->json($json);
            } else {
                $this->view->ok = 'ok';
            }
//           
        }
    }

    public function confirmAction() {
        $key = $this->_request->getParam('key');

        // Key should not be blank
        if ($key != "") {

            // $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
            $user = new Application_Model_DbTable_Users();
            $user_code = $user->getUserByCode($key);

//        $account = $em->getRepository('Entities\Account')
//                      ->findOneByRecovery($this->_request->getParam('key'));
            // Was the account found?
            if ($user_code) {

                $active = 1;
                $code = "";
                $user->updateUserActiveCode($user_code->id, $active, $code);
//          // Account found, so confirm it and reset the recovery attribute
//          $account->setConfirmed(1);
//          $account->setRecovery("");
//
//          // Save the account to the database
//          $em->persist($account);
//          $em->flush();
                // Set the flash message and redirect the user to the login page
                $this->_helper->flashMessenger->addMessage(
                        Zend_Registry::get('config')->messages->register->confirm->successful
                );
                $this->view->success = true;
                //$this->_helper->redirector('login', 'auth');
            } else {

                // Set the flash message and redirect the user to the login page
                $this->_helper->flashMessenger->addMessage(
                        Zend_Registry::get('config')->messages->register->confirm->failed
                );
                $this->view->success = false;
                // $this->_helper->redirector('login', 'auth');
            }
        }
    }

    public function lostAction() {
        $form = new Application_Form_Lost();
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            if ($request->isPost()) {

                // If form is valid, make sure the e-mail address is associated
                // with an account
                if ($form->isValid($request->getPost())) {

                    $user = new Application_Model_DbTable_Users();
                    $user_email = $user->getUserByEmail($form->getValue('email'));
//          $account = $this->em->getRepository('Entities\Account')
//                    ->findOneByEmail($form->getValue('email'));          
                    // If account is found, generate recovery key and mail it to
                    // the user
                    if ($user_email) {

                        // Generate a random password
                        // $account->setRecovery($this->_helper->generateID(32));
                        $code = sha1(uniqid($user_email->username . $user_email->email, true));
                        $user->updateUserCode($user_email->id, $code);
//            $this->em->persist($account);
//            $this->em->flush();
                        // Create a new mail object
                        $mail = new Zend_Mail();

                        // Set the e-mail from address, to address, and subject
                        $mail->setFrom(Zend_Registry::get('config')->email->support);
                        $mail->addTo($form->getValue('email'));
                        $mail->setSubject("Album Cd: Generate a new password");

                        // Retrieve the e-mail message text
                        include "_email_lost_password.phtml";

                        // Set the e-mail message text
                        $mail->setBodyText($email);

                        // Send the e-mail
                        $mail->send();

                        $this->_helper->flashMessenger->addMessage('Check your e-mail for further instructions');
                        $this->_helper->redirector('login', 'auth');
                    }
                }
//        else {
//          $this->view->errors = $form->getErrors();
//        }
            }

            $this->view->form = $form;
        }
        if ($request->isXmlHttpRequest()) {


            $data = $form->isValid($request->getPost());

            if (!$data) {

                $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                $this->_helper->json($json);
            } else {
                $this->view->ok = 'ok';
            }
//           
        }
    }

    public function recoverAction() {
        $key = $this->_request->getParam('key');

        if ($key != "") {

//      $account = $this->em->getRepository('Entities\Account')
//                ->findOneByRecovery($key);  
            $user = new Application_Model_DbTable_Users();
            $user_code = $user->getUserByCode($key);

            // If account is found, generate recovery key and mail it to
            // the user
            if ($user_code) {

                // Generate a random password
                $password = $this->generetePass(8);
                // $account->setPassword($password);
                $salt = Zend_Registry::get('config')->salt;
                $passwordsha1 = sha1($password . $salt);

                $active = 1;
                $code = "";
                $user->updateUserPasswordActiveCode($user_code->id, $passwordsha1, $salt, $active, $code);

                // Erase the recovery key
//        $account->setRecovery("");    
//
//        // Save the account
//        $this->em->persist($account);
//        $this->em->flush();
                // Create a new mail object
                $mail = new Zend_Mail();

                // Set the e-mail from address, to address, and subject
                $mail->setFrom(Zend_Registry::get('config')->email->support);
                $mail->addTo($user_code->email);
                $mail->setSubject("Album Cd: Your password has been reset");

                // Retrieve the e-mail message text
                include "_email_recover_password.phtml";

                // Set the e-mail message text
                $mail->setBodyText($email);

                // Send the e-mail
                $mail->send();

                $this->_helper->flashMessenger->addMessage(
                        Zend_Registry::get('config')->messages->account->password->reset
                );
                $this->_helper->redirector('login', 'auth');
            }
        }

        // Either a blank key or non-existent key was provided
        $this->_helper->flashMessenger->addMessage(
                Zend_Registry::get('config')->messages->account->password->nokey
        );
        $this->_helper->redirector('login', 'auth');
    }

    public function passwordAction() {
        // Make sure the user is logged-in
        //  $this->_helper->LoginRequired();
        $users = new Application_Model_DbTable_Users();
        $userRole = new Application_Model_UserRole();
        $passwordResource = new Application_Model_PasswordResource();
        $id = Zend_Auth::getInstance()->getIdentity()->id;
        $user = $users->getUser($id);
        $passwordResource->owner_id = $user['id'];
        // echo $id;
        $form = new Application_Form_Password();
        $request = $this->getRequest();
        if (Zend_Registry::get('acl')->isAllowed($userRole, $passwordResource, 'password')) {
            if (!$request->isXmlHttpRequest()) {
                if ($request->isPost()) {

                    if ($form->isValid($request->getPost())) {

                        // $em = $this->_helper->EntityManager();
                        $password = $form->getValue('password');
                        $salt = Zend_Registry::get('config')->salt;
                        $passwordsha1 = sha1($password . $salt);
                        // Set the account password
                        //$this->view->account->setPassword($form->getValue('password'));
                        $users->updateUserPassword($id, $passwordsha1, $salt);
                        // Save the account to the database
//          $em->persist($this->view->account);
//          $em->flush();

                        $this->_helper->flashMessenger->addMessage('Your password has been updated!');
                        $this->_helper->redirector('index', 'index');
                    }
//        else {
//          $this->view->errors = $form->getErrors();
//        }
                }

                $this->view->form = $form;
            }

            if ($request->isXmlHttpRequest()) {


                $data = $form->isValid($request->getPost());

                if (!$data) {

                    $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                    $this->_helper->json($json);
                } else {
                    $this->view->ok = 'ok';
                }
//           
            }
        } else {

            $request->setControllerName('error')
                    ->setActionName('denied');
        }
    }

    public function profileAction() {
        // Make sure the user is logged-in
        //  $this->_helper->LoginRequired();
        $users = new Application_Model_DbTable_Users();
        $userRole = new Application_Model_UserRole();
        $profileResource = new Application_Model_ProfileResource();
        $id = Zend_Auth::getInstance()->getIdentity()->id;
        $user = $users->getUser($id);
        $profileResource->owner_id = $user['id'];
        // echo $id;
        $form = new Application_Form_Profile();
        $request = $this->getRequest();
        if (Zend_Registry::get('acl')->isAllowed($userRole, $profileResource, 'profile')) {
            if (!$request->isXmlHttpRequest()) {
                if ($request->isPost()) {

                    if ($form->isValid($request->getPost())) {

                        $username = $form->getValue('username');
                        $email = $form->getValue('email');
                        $users->updateUserProfile($id, $username, $email);
                        // Save the account to the database
//          $em->persist($this->view->account);
//          $em->flush();

                        $this->_helper->flashMessenger->addMessage('Your profile has been updated!');
                        $this->_helper->redirector('index', 'index');
                    }
//        else {
//          $this->view->errors = $form->getErrors();
//        }
                }

                $this->view->form = $form;
                $form->populate($user);
            }

            if ($request->isXmlHttpRequest()) {


                $data = $form->isValid($request->getPost());

                if (!$data) {

                    $json = $form->getMessages();
//                  var_dump($json);
//                  die;
                    $this->_helper->json($json);
                } else {
                    $this->view->ok = 'ok';
                }
//           
            }
        } else {

            $request->setControllerName('error')
                    ->setActionName('denied');
        }
    }

    public function deleteAction() {
        $users = new Application_Model_DbTable_Users();
        $userRole = new Application_Model_UserRole();
        $userResource = new Application_Model_DeleteAuthResource();
        //$session = new Zend_Session_Namespace('Application');
        $request = $this->getRequest();
        $id = Zend_Auth::getInstance()->getIdentity()->id;
        $user = $users->getUser($id);
        $userResource->owner_id = $user['id'];



        if (Zend_Registry::get('acl')->isAllowed($userRole, $userResource, 'delete')) {
            if ($request->isPost()) {
                $del = $request->getPost('del');
                if ($del == 'Yes') {

                    // $albums = new Application_Model_DbTable_Albums();
                    $users->deleteUser($id);

                    $this->logoutAction();
                } else {

                    $this->_helper->redirector('index', 'index');
                }
            }   

                // $session = new Zend_Session_Namespace('Application');
//            echo urldecode($session->redirect);
//            die();
                // $this->_helper->redirector('index','index');
                // ); //, array('prependBase' => false));
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

