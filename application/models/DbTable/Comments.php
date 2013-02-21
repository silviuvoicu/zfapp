<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract {

    protected $_name = 'cd_comments';

    public function getComment($id) {
        $id = (int) $id;
        $row = $this->fetchRow('comment_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find this comment $id");
        }
        return $row->toArray();
    }

    public function addComment( $comment, $cd_id, $user_id) {
        $data = array(
            'comment' => $comment,
            'cd_id' => $cd_id,
            'user_id' => $user_id
        );
        $this->insert($data);
    }

    public function updateComment($id, $comment) {
        $data = array(
            'comment' => $comment
           
        );
        $this->update($data, 'comment_id=' . (int) $id);
    }

    public function deleteComment($id) {
        $this->delete('comment_id=' . (int) $id);
    }

}

