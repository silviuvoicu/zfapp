<?php
class My_Validate_EmailAddress  extends Zend_Validate_EmailAddress
{
    protected $singleErrorMessage = "Email address is invalid";

    public function isValid($value)
    {
        $valid = parent::isValid($value);
        if (!$valid) {
            $this->_messages = array($this->getSingleErrorMessage());
        }
        return $valid;
    }

    public function getSingleErrorMessage()
    {
        return $this->singleErrorMessage;
    }

    public function setSingleErrorMessage($singleErrorMessage)
    {
        $this->singleErrorMessage = $singleErrorMessage;
        return $this;
    }
}
