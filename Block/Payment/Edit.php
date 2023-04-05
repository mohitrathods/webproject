<?php 
class Block_Payment_Edit extends Block_Core_Abstracts{
    public function __construct(){
        $id = Ccc::getModel('Core_Request')->getParam('id');

        if(!$id){
            $paymentRow = Ccc::getModel('Payment_Row');
            $this->setTemplate('payment/edit.phtml')->setData(['payments' => $paymentRow]);
        }

        else {
            $paymentRow = Ccc::getModel('Payment_Row')->load($id);
            $this->setTemplate('payment/edit.phtml')->setData(['payments' => $paymentRow]);
        }


    }
}

?>