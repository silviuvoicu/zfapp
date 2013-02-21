<?php

class Application_Model_ProfileResource implements Zend_Acl_Resource_Interface
{
    public $owner_id = null;
    public $resource_id = 'auth:profile';
    public function getOwnerId(){
        return $this->owner_id;
    }
    public function getResourceId(){
        return $this->resource_id;
    }
}

