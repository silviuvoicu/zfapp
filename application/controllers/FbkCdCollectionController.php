<?php

class FbkcdcollectionController extends Zend_Controller_Action {
    const FACEBOOK_ALLOW_URL = 'https://www.facebook.com/dialog/oauth';

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
// action body
// Zend_Debug::dump($this->_getAllParams());
//die();
// Grab the signed request and setup the Facebook model
        $signed_request = $this->_getParam('signed_request', null);
//        var_dump($signed_request);
//       var_dump(empty($signed_request));
//        die();
        if (empty($signed_request)) {
          ;
           throw new Application_Model_FacebookException('Security Error');
        }
        $FB = new Application_Model_Facebook($signed_request);
// if the user has not installed,
// redirect to the allow URL
        if (!$FB->hasInstalled) {
            $this->view->redirect_url =
                    FbkcdcollectionController::FACEBOOK_ALLOW_URL
                    . '?client_id=' . Application_Model_Facebook::FACEBOOK_APP_ID
                    . '&redirect_uri=' . $_SERVER['HTTP_REFERER'];
            $this->_helper->viewRenderer->setScriptAction('redirect');
        }else{
               $this->_forward('index', 'index');
        }
    }

}

