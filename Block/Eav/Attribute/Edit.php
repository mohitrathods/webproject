<?php

class Block_Eav_Attribute_Edit extends Block_Core_Abstracts {
    public function __construct(){
        parent::__construct();

        $this->getTemplate('eav/attribute/edit.phtml');
    }

    public function getCollection() {
        $id = Ccc::getModel('Core_Request')->getParam('id');

        if(!$id){
            $attributeRow = Ccc::getModel('Eav_Attribute');
        }

        else{
            $attributeRow = Ccc::getModel('Eav_Attribute')->load($id);
        }

        return $attributeRow;
    }
}

?>