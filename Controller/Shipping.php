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
    public function setModel($model){
        $this->model = $model;
        return $this;
    }

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

    public function addAction(){
        $this->getTemplate("shipping/add.phtml");
    }

    public function insertAction(){
        $shipping = $this->getRequest()->getPost('shipping');

        date_default_timezone_set("Asia/Kolkata");
        $dateTime = date("Y-m-d h:i:sA");
        $shipping['created_at'] = $dateTime;

        $this->getModel()->insert($shipping);
        
        $this->redirect("index.php?c=shipping&a=grid");
    }

    public function editAction(){
        $query = "SELECT * FROM `shipping` WHERE `shipping_method_id` = '{$this->getRequest()->getParam('id')}'";

        $shippingRow = $this->getModel()->fetchRow($query);

        $this->setShipping($shippingRow);

        $this->getTemplate("shipping/edit.phtml");
    }

    public function updateAction(){
        $shipping = $this->getRequest()->getPost('shipping');

        date_default_timezone_set("Asia/Kolkata");
        $dataTime = date("Y-m-d h:i:sA");
        $shipping['updated_at'] = $dataTime;

        $shippingId = $this->getRequest()->getParam('id');

        $condition['shipping_method_id'] = $shippingId;

        $this->getModel()->update($shipping , $condition);

        $this->redirect("index.php?c=shipping&a=grid");
    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');
        
        $this->getModel()->delete($deleteId);

        $this->redirect("index.php?c=shipping&a=grid");
        
    }
}

?>