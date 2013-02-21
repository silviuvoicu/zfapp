<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        $this->setName('profile');
        $this->setMethod('post');
        $this->setAction('/auth/profile');
        
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
        $username_validator =  new Zend_Validate_Db_NoRecordExists('users', 'username',array('field' => 'id', 'value' => Zend_Auth::getInstance()->getIdentity()->id));
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

         $email_validator = new Zend_Validate_Db_NoRecordExists('users', 'email',array('field' => 'id', 'value' => Zend_Auth::getInstance()->getIdentity()->id));
         $email_validator ->setMessage('the provided e-mail address is already associated with a registered user.');
        $email->addValidator($email_validator,false);//array( 'messages' => array( Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>'the provided e-mail address is already associated with a registered user.')));
        $email->removeDecorator('label');
        $email->removeDecorator('htmlTag');
        
        
        $submit = new Zend_Form_Element_Submit('profile');
        $submit->setLabel('Update Profile');
        $submit->removeDecorator('DtDdWrapper');

        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_profile.phtml'))));

        $this->addElements(array($username, $email, $submit));
        
    }


}

