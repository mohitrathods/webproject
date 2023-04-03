<?php

require_once 'Controller/Core/Action.php';

class Controller_Payment extends Contoller_Core_Action{
    public function gridAction() {
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `payment`";
        $payments = Ccc::getModel('Payment_Row')->fetchAll($query);
        
        try {
            if(!$payments){
                throw new Exception("payment data not found",1);
            }

            $this->getView()->setTemplate('payment/grid.phtml')->setData(['payments' => $payments])->render();
        } 
        catch (Exception $e) {
            Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }
    }    

    public function addAction(){
        $paymentRow = Ccc::getModel('Payment_Row');
        $this->getView()->setTemplate('payment/edit.phtml')->setData(['payments' => $paymentRow])->render();
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();
        $id = $this->getRequest()->getParam('id');
        $paymentRow = Ccc::getModel('Payment_Row')->load($id);

        try {
            if(!$id){
                throw new Exception("data not found",1);
            }

            $this->getView()->setTemplate('payment/edit.phtml')->setData(['payments' => $paymentRow])->render();
        } 
        catch (Exception $e) {
            Ccc::getModel('Core_Message')->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }
    }

    public function saveAction(){
        $this->getMessage()->getSession()->start();
        $id = $this->getRequest()->getParam('id');

        if(!$id){
            //add
            $addPayment = $this->getRequest()->getPost('payment');

            try {
                if(!$addPayment){
                    throw new Exception("data not inserted",1);
                }

                else{
                    $row = Ccc::getModel('Payment_Row')->setData($addPayment);
                    date_default_timezone_set("Asia/Kolkata");
                    $datetime = date("Y:m:d h:i:sA");
                    $row->created_at = $datetime;
                    $row->save();                    
                    Ccc::getModel('Core_Message')->addMessages("data inserted successfully",Model_Core_Message::SUCCESS);
                }
            } 
            catch (Exception $e) {
                Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
            }
        }
        else{
            //update
            $updatePayment = $this->getRequest()->getPost('payment');

            try {
                if(!$updatePayment){
                    throw new Exception("data not updated",1);
                }

                else{
                    $row = Ccc::getModel('Payment_Row')->setData($updatePayment);
                    date_default_timezone_set("Asia/Kolkata");
                    $datetime = date("Y:m:d h:i:sA");
                    $row->created_at = $datetime;
                    $row->save();

                    Ccc::getModel('Core_Message')->addMessages("data updated successfully", Model_Core_Message::SUCCESS);
                }
            } 
            catch (Exception $e) {
                Ccc::getModel('Core_Message')->addMessages($e->getMessage() ,Model_Core_Message::FAILURE);
            }
        }

        $this->redirect('payment', 'grid',[],true);
    }

    public function deleteAction() {
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');

        try {
            if(!$deleteId){
                throw new Exception("data not deleted",1);
            }
            else{
                Ccc::getModel('Payment_Row')->load($deleteId)->delete();
                Ccc::getModel('Core_Message')->addMessages("data deleted successfully",Model_Core_Message::SUCCESS);
            }
        } 
        catch (Exception $e) {
            Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->redirect('payment', 'grid',[],true);
    }

}

?>
