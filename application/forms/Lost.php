<?php

class Application_Form_Lost extends Zend_Form
{

    public function init()
    {
        $this->setName('lost');
      $this->setMethod('post');
      $this->setAction('/auth/lost');
      
      
      
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

         $email_validator = new Zend_Validate_Db_RecordExists('users', 'email');
         $email_validator ->setMessage('the provided e-mail address is not associated with a registered user.');
        $email->addValidator($email_validator,false);//array( 'messages' => array( Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>'the provided e-mail address is already associated with a registered user.')));
        $email->removeDecorator('label');
        $email->removeDecorator('htmlTag');

//      $email = new Zend_Form_Element_Text('email');
//      $email->setAttrib('size', 50);
//      $email->setRequired(true);
//      $email->addErrorMessage('Please provide a valid e-mail address');
//      $email->addValidator('EmailAddress');
//      $email->removeDecorator('label');
//      $email->removeDecorator('htmlTag');
//      //$email->removeDecorator('Errors');

      $submit = new Zend_Form_Element_Submit('send');
      $submit->setLabel('Recover your password');
      $submit->removeDecorator('DtDdWrapper');
      $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_lost.phtml'))));

      $this->addElements(array($email, $submit));

    }


}

