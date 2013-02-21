<?php

class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{

    protected $_name = 'cds';
    
    public function getAlbum($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = '.$id);
        if(!$row){
            throw new Exception("Could not find Album(Cd) with $id");
        }
        return $row->toArray();
    }
    public function addAlbum($interpret,$titel,$jahr,$user_id)
    {
        $data = array(
            'interpret' => $interpret,
            'titel'     => $titel,
            'jahr'      => $jahr,
            'user_id'   => $user_id
        );
        $this->insert($data);
    }
      public function updateAlbum($id,$interpret,$titel,$jahr)
    {
        $data = array(
            'interpret' => $interpret,
            'titel'     => $titel,
            'jahr'      => $jahr
        );
        $this->update($data, 'id='.(int)$id);
    }
    public function deleteAlbum($id)
    {
        $this->delete('id='.(int)$id);
    }


}

