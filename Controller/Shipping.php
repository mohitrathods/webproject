<?php

require_once "Controller/Core/Action.php";

require_once 'Model/Shipping.php';

class Controller_Shipping extends Contoller_Core_Action{

    protected $shipping = [];

    protected $shippingId = null;

    protected $model = null;


    //------------- setter getter of shipping
    public function setShipping($shipping){
        $this->shipping = $shipping;
        return $this;
    }

    public function getShipping(){
        return $this->shipping;
    }

    //------------- setter getter of model
    // public function setModel($model){
    //     $this->model = $model;
    //     return $this;
    // }

    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Shipping();
        $this->model =  $model;
        return $model;
    }


    // all actions
    public function gridAction(){
         $query = "SELECT * FROM `shipping` WHERE 1";
        $shipping = $this->getModel()->fetchAll($query);
        
        $this->setShipping($shipping);

        $this->getTemplate("shipping/grid.phtml");

    }
}

?>