<?php

class Application_Form_Login extends Zend_Form {

    public function init() {
        $this->setName("login");
        $this->setMethod('post');

        $this->setAction('/auth/login');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username :');
        $username->setAttrib(size, 50);
        $username->setRequired(true);
        $username->removeDecorator('label');
        $username->removeDecorator('htmlTag');
        $username->addFilters(array('StringTrim', 'StringToLower'));
        $username->addValidator('Alnum', true);
        $username->addValidator('StringLength', false, array(5, 50));
        $username->addErrorMessage('Your username can consist solely of letters and numbers and can the length between 5 and 50 characters');


        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:');
        $password->setAttrib('size', 50);
        $password->setRequired(true);
        $password->addFilter('StringTrim');
        $password->addValidator('StringLength', false, array('min' => 6));
        $password->removeDecorator('label');
        $password->removeDecorator('htmlTag');
        // $password->removeDecorator('Errors');
        $password->addErrorMessage('Please provide a valid password 6 characters at least');

//        $config = Zend_Registry::get('config');
//
//        $public = $config->recaptcha->public;
//        $private = $config->recaptcha->private;
//        $recaptcha_service = new Zend_Service_ReCaptcha($public, $private);
//
//// then set the Recaptcha adapter 
//        $adapter = new Zend_Captcha_ReCaptcha();
//        $adapter->setService($recaptcha_service);
//
//// then set  the captcha element to use the ReCaptcha Adapter 
//        $recaptcha = new Zend_Form_Element_Captcha('recaptcha', array(
//                    'label' => "Are you a human?",
//                    'captcha' => $adapter
//                ));
//
//        $recaptcha ->removeDecorator('label')
//                ->removeDecorator('htmlTag');
        //    $captcha = new Zend_Form_Element_Captcha('captcha', array(
//    'label' => "Please verify you're a human",
//    'captcha' => 'Figlet',
//    'captchaOptions' => array(
//        'captcha' => 'Figlet',
//        'wordLen' => 6,
//        'timeout' => 300,
//    ),
//));
        /* new Zend_Form_Element_Captcha('captcha');
          $captcha ->setLabel('Prove your self human:');
          $captcha ->setCaptcha('Dumb')
          ->setIgnore(true);
         */
        $submit = new Zend_Form_Element_Submit('login');
        $submit->setRequired(false);
        $submit->setLabel('Login');
        $submit->setIgnore(true);
        $submit->removeDecorator('DtDdWrapper');


        $this->setDecorators(array(array('ViewScript', array('viewScript' => '_form_login.phtml'))));

        $this->addElements(array($username, $password,
         //   $recaptcha,
            $submit));








        /*
          $this->addElement('text', 'username', array(
          'filters' => array('StringTrim', 'StringToLower'),
          'validators' => array(
          array('StringLength', false, array(5, 50)),
          ),
          'required' => true,
          'label' => 'Username:',
          ));

          $this->addElement('password', 'password', array(
          'filters' => array('StringTrim'),
          'validators' => array(
          array('StringLength', false, array(0, 50)),
          ),
          'required' => true,
          'label' => 'Password:',
          ));

          $this->addElement('submit', 'login', array(
          'required' => false,
          'ignore' => true,
          'label' => 'Login',
          ));
         */
    }

}

