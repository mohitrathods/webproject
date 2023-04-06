<?php

class Controller_Eav_Attribute extends Contoller_Core_Action{

    public function gridAction(){
        echo "inseide grid";

       $attributeGrid = new Block_Attribute_Grid();
       $this->getLayout()->getChild('content')->addChild('grid',$attributeGrid);
       $attributeGrid->getCollection();
       $this->getLayout()->render();
    }
}

?>