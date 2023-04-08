<?php
require_once 'Controller/Core/Action.php';

class Controller_Eav_Attribute extends Contoller_Core_Action {
    public function gridAction(){
        Ccc::getModel('Core_Session')->start();

        try {
            $attributeGrid = new Block_Eav_Attribute_Grid();
            $this->getLayout()->getChild('content')->addChild('grid',$attributeGrid);
            $this->getLayout()->render();

            $layout = $this->getLayout();
            //ccc::getmodel('eav_attribute');
            // $layout->createBlock('Eav_Attribute_Grid')->setData(['' => $x]); //make this change 
        } 
        catch (Exception $e) {
            
        }
    }  
    
    public function addAction() {
        Ccc::getModel('Core_Session')->start();

        $adminAdd = new Block_Eav_Attribute_Edit();
        $this->getLayout()->getChild('content')->addChild('add',$adminAdd);
        $this->getLayout()->render();
    }
}

?>