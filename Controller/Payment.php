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
        $model = new Model_Core_Table();
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


}
?>