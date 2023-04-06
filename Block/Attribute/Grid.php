<?php


class Block_Attribute_Grid extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();

	}

    public function getCollection(){

        $query = "SELECT * FROM `eav_attribute`";
        $attribute = Ccc::getModel('Attribute_Row')->fetchAll($query);
        $this->setTemplate('attribute/grid.phtml')->setData(['attributes' => $attribute]);
    }
    

    

  
}

?>