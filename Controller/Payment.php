<?php

require_once 'Controller/Core/Action.php';
require_once 'Model/Payment.php';

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

    // public function setModel($model){
    //     $this->model = $model;
    //     return $this;
    // }

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
        $query = "SELECT * FROM `payment` WHERE 1";
        $payment = $this->getModel()->fetchAll($query);
        
        $this->setPayment($payment);

        $this->getTemplate("payment/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("payment/add.phtml");
    }

    public function insertAction(){
        $payment = $this->getRequest()->getPost('payment');

        date_default_timezone_set("Asia/Kolkata");
        $dateTime = date("Y-m-d h:i:sA");
        $payment['created_at'] = $dateTime;

        $this->getModel()->insert($payment);

        $this->redirect("index.php?c=payment&a=grid");
    }

    public function editAction(){
        $query = "SELECT * FROM `payment` WHERE `payment_method_id` = '{$this->getRequest()->getParam('id')}'";

        $paymentRow = $this->getModel()->fetchRow($query);

        $this->setPayment($paymentRow);

        $this->getTemplate("payment/edit.phtml");
    }

    public function updateAction(){
        $payment = $this->getRequest()->getPost('payment');

        date_default_timezone_set("Asia/Kolkata");
        $dateTime =  date("Y-m-d h:i:sA");
        $payment['updated_at'] = $dateTime;

        $paymentId = $this->getRequest()->getParam('id');

        $condition['payment_method_id'] = $paymentId;

        $this->getModel()->update($payment, $condition);

        $this->redirect("index.php?c=payment&a=grid");
    }

    public function deleteAction (){
        $deleteId = $this->getRequest()->getParam('id');

        $this->getModel()->delete($deleteId);

        $this->redirect("index.php?c=payment&a=grid");
    }


}
?>