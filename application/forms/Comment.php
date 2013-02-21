<?php

class Application_Form_Comment extends Zend_Form {

    public function init() {
        $this->setName('commentForm');
        $id = new Zend_Form_Element_Hidden('comment_id');
        $id->addFilter('Int')
                ->removeDecorator('label')
                ->removeDecorator('htmlTag');
        $idCd = new Zend_Form_Element_Hidden('cd_id ');
        $idCd->addFilter('Int')
                ->removeDecorator('label')
                ->removeDecorator('htmlTag');
        $comment = new Zend_Form_Element_Textarea('comment');
        $comment->setLabel('Comment')
                ->setRequired(true)
                ->setAttrib('COLS', '50')
                ->setAttrib('ROWS', '5')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addErrorMessage('Please provide the comment')
                ->removeDecorator('label')
                ->removeDecorator('htmlTag');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $submit->setRequired(false);
        $submit->setIgnore(true);
        $submit->removeDecorator('DtDdWrapper');
        $this->setDecorators(array(array('ViewScript', array('viewScript' => '_form_comment.phtml'))));
        $this->addElements(array($id, $idCd, $comment, $submit));
    }

}

