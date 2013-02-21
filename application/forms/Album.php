<?php

class Application_Form_Album extends Zend_Form {

    public function init() {
        $this->setName('album');
        $this->setMethod('post');
        $this->setAction('/index/add');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        $id->removeDecorator('label');
        $id->removeDecorator('htmlTag');
        $artist = new Zend_Form_Element_Text('interpret');
        $artist->setLabel('Artist');
        $artist->setAttrib('size', 50);
        $artist->setRequired(true);
        $artist->removeDecorator('label');
        $artist->removeDecorator('htmlTag');
        $artist->addFilter('StripTags');
        $artist->addFilter('StringTrim');
        //$artist->addValidator('NotEmpty');
        $artist->addValidator('StringLength', false, array(2, 50));
        $artist->addErrorMessage('Please provide an artist name at least 2 characters');
        $title = new Zend_Form_Element_Text('titel');
        $title->setLabel('Title');
        $title->setAttrib('size', 50);
        $title->setRequired(true);
        $title->addFilter('StripTags');
        $title->addFilter('StringTrim');
       // $title->addValidator('NotEmpty');
        $title->addValidator('StringLength', false, array(1, 50));
        $title->removeDecorator('label');
        $title->removeDecorator('htmlTag');
        $title->addErrorMessage('Please provide title for the album at least 1 characters');
        $year = new Zend_Form_Element_Text('jahr');
        $year->setLabel('Year');
        $year->setAttrib('size', 4);
        $year->setRequired(true);
        $year->addFilter('StripTags');
        $year->addFilter('StringTrim');
        $year->addValidator('Regex',true,array('/\d{4}/'));
        $today = getdate();
        $year->addValidator('Between',true,array('1930',$today['year']));
        $year->addValidator('Date', false, YYYY);
        $year->removeDecorator('label');
        $year->removeDecorator('htmlTag');
        $year->addErrorMessage('Please provide an year for the album, in the format YYYY eg. 1980 (between 1930 and '.$today['year']. ')');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $submit->setRequired(false);
        $submit->setIgnore(true);
        $submit->removeDecorator('DtDdWrapper');
        $this->setDecorators(array(array('ViewScript', array('viewScript' => '_form_album.phtml'))));
        $this->addElements(array($id, $artist, $title, $year, $submit));
    }

}

