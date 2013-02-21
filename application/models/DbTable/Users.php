<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    
     public function getUser($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = '.$id);
        if(!$row){
            throw new Exception("Could not find User $id");
        }
        return $row->toArray();
    }
     public function getUserByCode($code)
    {
        //$id = (int)$id;
        $row = $this->fetchRow('code =  \''.$code.'\'');
//        if(!$row){
//            throw new Exception("Could not find User ");
//        }
        return $row;
    }
     public function getUserByEmail($mail)
    {
        //$id = (int)$id;
        $row = $this->fetchRow('email =  \''.$mail.'\'');
        if(!$row){
            throw new Exception("Could not find User $email");
        }
        return $row;
    }
     public function getUserByUserName($username)
    {
       // $id = (int)$id;
//         var_dump('username = \''.$username.'\'');
//         die();
        $row = $this->fetchRow('username = \''.$username.'\'');
        if(!$row){
            throw new Exception("Could not find User $username");
        }
        return $row;
    }
    public function addUser($username,$email,$code,$password,$salt,$date_created)
    {
        $data = array(
            'username' => $username,
            'email'     => $email,
            'code'      => $code,
            'password'   => $password,
            'salt'      => $salt,
            'date_created' => $date_created
        );
        $this->insert($data);
    }
     public function updateUserActiveCode($id,$active,$code)
    {
        $data = array(
            'active' => $active,
            'code'     => $code
          
        );
        $this->update($data, 'id='.(int)$id);
    }
     public function updateUserPasswordActiveCode($id,$password,$salt,$active,$code)
    {
        $data = array(
            'password' => $password,
            'salt' => $salt,
            'active' => $active,
            'code'     => $code
          
        );
        $this->update($data, 'id='.(int)$id);
    }
     public function updateUserCode($id,$code)
    {
        $data = array(
         'code'     => $code
       );
        $this->update($data, 'id='.(int)$id);
    }
     public function updateUserPassword($id,$password,$salt)
    {
        $data = array(
         'password'     => $password,
            'salt'    => $salt
       );
        $this->update($data, 'id='.(int)$id);
    }
      public function updateUserProfile($id,$username,$email)
    {
        $data = array(
            'username' => $username,
            'email'     => $email,
           );
        $this->update($data, 'id='.(int)$id);
    }
    public function deleteUser($id)
    {
        $this->delete('id='.(int)$id);
    }




}

