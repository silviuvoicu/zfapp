<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        
        $this->setName('register');
        $this->setMethod('post');
        $this->setAction('/auth/register');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Your Username:');
        $username->setAttrib('size', 50);
        $username->setRequired(true);
        $username->removeDecorator('label');
        $username->removeDecorator('htmlTag');
        $username_notempty = new Zend_Validate_NotEmpty();
        $username_notempty ->setMessage('Your username can consist solely of letters and numbers and can the length between 5 and 50 characters');
        $username->addValidator($username_notempty, true);
         
        $username_alnum = new Zend_Validate_Alnum();
        $username_alnum->setMessage('Your username can consist solely of letters and numbers and can the length between 5 and 50 characters');
        $username->addValidator($username_alnum,true); 
        $username_stringlength = new Zend_Validate_StringLength(array('min' => 5,'max' => 50));
        $username_stringlength->setMessage('Your username can consist solely of letters and numbers and can the length between 5 and 50 characters');
        $username->addValidator($username_stringlength, true );
        $username_validator =  new Zend_Validate_Db_NoRecordExists('users', 'username');
        $username_validator ->setMessage('the provided username is already associated with a registered user.');
        $username->addValidator($username_validator);
     
            
        $email = new Zend_Form_Element_Text('email');

        $email->setLabel('Your E-mail Address:');
        $email->setAttrib('size', 50);
        $email->setRequired(true);
         $email_notempty = new Zend_Validate_NotEmpty();
        $email_notempty ->setMessage('Please provide a valid e-mail address');
        $email->addValidator($email_notempty, true);
        $email->addPrefixPath('My_Validate',  'My/Validate/','validate');
        $email_validator_valid = new My_Validate_EmailAddress();
       $email_validator_valid ->setSingleErrorMessage('Please provide a valid e-mail address');


      
        $email->addValidator($email_validator_valid, true);

         $email_validator = new Zend_Validate_Db_NoRecordExists('users', 'email');
         $email_validator ->setMessage('the provided e-mail address is already associated with a registered user.');
        $email->addValidator($email_validator,false);//array( 'messages' => array( Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>'the provided e-mail address is already associated with a registered user.')));
        $email->removeDecorator('label');
        $email->removeDecorator('htmlTag');
     

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

        $submit = new Zend_Form_Element_Submit('register');
        $submit->setLabel('Create Your Account');
        $submit->removeDecorator('DtDdWrapper');

        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_register.phtml'))));

        $this->addElements(array($username, 
            //$zipCode, 
            $email, $password, $confirmPswd, $submit));
    }


}

