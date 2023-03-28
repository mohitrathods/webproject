<?php

require_once 'Controller/Core/Action.php';
require_once 'Model/Payment.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Message.php';

class Controller_Payment extends Contoller_Core_Action{

    protected $paymentId = null;

    protected $payment = [];

    protected $model = null;

    //------------- set get of payment
    public function setPayment($payment){
        $this->payment = $payment;
    }

    public function getPayment(){
        return $this->payment;
    }

    //------------- set get  of model

    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Payment();
        $this->model = $model;
        return $model;
    }

    //------------ all ACTIONS
    public function gridAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `payment` WHERE 1";
        $payment = $this->getModel()->fetchAll($query);

        try {
            if(!$payment){
                throw new Exception("data not found",1);
            }

            $this->setPayment($payment);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE)            ;
        }

        $this->getTemplate("payment/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("payment/add.phtml");
    }

    public function insertAction(){
        $this->getMessage()->getSession()->start();
        $payment = $this->getRequest()->getPost('payment');

        try {
            if(!$payment){
                throw new Exception("row not inserteD" , 1);
            }
            else{
                $this->getMessage()->addMessages("payment row inserted successfully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $payment['created_at'] = $dateTime;
            $this->getModel()->insert($payment);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('payment' , 'grid');
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `payment` WHERE `payment_method_id` = '{$this->getRequest()->getParam('id')}'";
        $paymentRow = $this->getModel()->fetchRow($query);

        try {
            if(!$paymentRow){
                throw new Exception("payment row not found" , 1);
            }

            $this->setPayment($paymentRow);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->getTemplate("payment/edit.phtml");
    }

    public function updateAction(){
        $this->getMessage()->getSession()->start();
        $payment = $this->getRequest()->getPost('payment');

        try{
            if(!$payment){
                throw new Exception('data not found' , 1);
            }
            else{
                $this->getMessage()->addMessages("data updated successfully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime =  date("Y-m-d h:i:sA");
            $payment['updated_at'] = $dateTime;
        }
        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }


        $paymentId = $this->getRequest()->getParam('id');

        try{
            if(!$paymentId){
                throw new Exception("payment id not found" ,1);
            }

            $condition['payment_method_id'] = $paymentId;
            $this->getModel()->update($payment, $condition);
        }
        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('payment' , 'grid' ,[] , true);
    }

    public function deleteAction (){
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');

        try{
            if(!$deleteId){
                throw new Exception("delte id not found" , 1);
            }
            else {
                $this->getMessage()->addMessages("data deleted successfully" , Model_Core_Message::SUCCESS);
            }
            
            $this->getModel()->delete($deleteId);
        }

        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('payment', 'grid', [], true );
    }


}
?>