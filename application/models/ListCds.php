<?php

class Application_Model_ListCds
{
   private $paginator = null;
  
  public function listCds($page,$secondPage,$cdId) {
		$db = Zend_Db_Table::getDefaultAdapter();
                
                $selectCds = new Zend_Db_Select($db);
		$selectCds->from('cds')
                        ->order('id  DESC');
                
//                ->join('cd_comments','cd_comments.cd_id=cds.id')
//                       ->join('users', 'users.id = cd_comments.user_id')
//                       ->where('cd_id = ?', $cdId);
//                          ->join('users','users.id = cds.user_id')
//                            ->where('book_id = ?', $cdId);
//                echo $selectCds;
//                die();
//                $pagAdapter = new Zend_Paginator_Adapter_DbSelect($selectCds);
//                $pagAdapter->
                
		$this->paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($selectCds) );
        $this->paginator->setItemCountPerPage(3)
                ->setCurrentPageNumber($page);
        
              //setPageRange(3);
       // var_dump($this->paginator);
		 $cds = array();
                 $comments = array();
                 $session = new Zend_Session_Namespace('Application');
        foreach($this->paginator as $i=>$cd) {
            $cdObj = new Application_Model_Cd($cd['id']);
            $cdObj->addTitel($cd['titel']);
            $cdObj->addInterpret($cd['interpret']);
            $cdObj->addJahr($cd['jahr']);
            $cdObj->addUserId($cd['user_id']);
            //var_dump($this->getComments($cd['id']));
            ($cd['id']==$cdId)? ($second = $secondPage):($second = $session->currentSecondPage[$cd['id']]);
            $comments = $this->getComments($cd['id'],$second);
            //unset($session->currentPage[$i]);
//         var_dump($comments);
//       die();
            $paginator[]= array_shift($comments);
            $cds['paginator']=$paginator;
         //  var_dump($paginator);
           // die();
            $cdObj->addComments($comments);
//            var_dump($comments);
//            die();
            //$cdObj->getComments($url)
            $cds[$cd['id']] = $cdObj;
        }
//         var_dump($cds);
//            die();
        return $cds;
    }

    public function getPaginator(){
        return $this->paginator;
    }

    private function getComments($cdId,$secondPage){
        // $session = new Zend_Session_Namespace('Application');
        $comments = array();
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectComments = new Zend_Db_Select($db);
        $selectComments->from('cd_comments',array('comment','comment_id','user_id'))
                       ->join('users', 'users.id = cd_comments.user_id',array('username'))
                       ->where('cd_id = ?', $cdId)
                       ->order('comment_id DESC');
       // $comments = $db->fetchAll($selectComments);
        //var_dump($selectComments);
       // $secondPage = $session->secondpage;
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($selectComments));
        $paginator->setItemCountPerPage(3)
               ->setCurrentPageNumber($secondPage);
         // var_dump($this->paginator);
        $comments['paginator']=$paginator;
         foreach($paginator as $comment) {
        $comments[] =$comment ;
        //return $comments;
       
         }
//    var_dump($comments);
//    die();
 return $comments;
}
    
}
