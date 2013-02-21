<?php

class Application_Form_Password extends Zend_Form
{

    public function init()
    {
        $this->setName('change_password');
        $this->setMethod('post');
        $this->setAction('/auth/password');
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:');
        $password->setAttrib('size', 50);
        $password->setRequired(true);
         $password_notempty = new Zend_Validate_NotEmpty();
        $password_notempty ->setMessage('Please provide a valid password 6 characters at least');
        $password->addValidator($password_notempty, true); 
        $password->addValidator('StringLength', false, array('min' => 6));
        $password->removeDecorator('label');
        $password->removeDecorator('htmlTag');
      //  $password->removeDecorator('Errors');
        $password->addErrorMessage('Please provide a valid password 6 characters at least');

        $confirmPswd = new Zend_Form_Element_Password('confirm_pswd');
        $confirmPswd->setLabel('Confirm Password:');
        $confirmPswd->setAttrib('size', 50);
        $confirmPswd->setRequired(true);
         $confirmPswd_notempty = new Zend_Validate_NotEmpty();
        $confirmPswd_notempty ->setMessage('The passwords do not match');
        $confirmPswd->addValidator($confirmPswd_notempty, true); 
        $confirmPswd->removeDecorator('label');
        $confirmPswd->removeDecorator('htmlTag');
        $confirmPswd->addValidator('Identical', false, array('token' => 'password'));
   //     $confirmPswd->removeDecorator('Errors');
        $confirmPswd->addErrorMessage('The passwords do not match');
        
        $submit = new Zend_Form_Element_Submit('update_password');
        $submit->setLabel('Update Password');
        $submit->removeDecorator('DtDdWrapper');

        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_password.phtml'))));

        $this->addElements(array($password, $confirmPswd, $submit));
    }


}

