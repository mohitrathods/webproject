<?php

class Block_Shipping_Edit extends Block_Core_Abstracts{

    public function __construct(){
        parent::__construct();

    }

    public function getCollection() {
        $id = Ccc::getModel('Core_Request')->getParam('id');

        if(!$id){
            $shippingRow = Ccc::getModel('Shipping_Row');
            $this->setTemplate('shipping/edit.phtml')->setData(['shippings' => $shippingRow]);
        }

        else {
            $shippingRow = Ccc::getModel('Shipping_Row')->load($id);
            $this->setTemplate('shipping/edit.phtml')->setData(['shippings' => $shippingRow]);
        }
    }
}

?>