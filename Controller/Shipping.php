<?php

require_once "Controller/Core/Action.php";
require_once 'Model/Shipping.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Message.php';

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
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `shipping` WHERE 1";
        $shipping = $this->getModel()->fetchAll($query);
       
        try {
            if(!$shipping){
                throw new Exception("shipping data not found" , 1);
            }

            $this->setShipping($shipping);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->getTemplate("shipping/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("shipping/add.phtml");
    }

    public function insertAction(){
        $this->getMessage()->getSession()->start();
        $shipping = $this->getRequest()->getPost('shipping');

        try {
            if(!$shipping){
                throw new Exception("data not inserted" , 1);
            }
            else{
                $this->getMessage()->addMessages("data inserted successfully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $shipping['created_at'] = $dateTime;
            $this->getModel()->insert($shipping);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('shipping', 'grid');
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `shipping` WHERE `shipping_method_id` = '{$this->getRequest()->getParam('id')}'";
        $shippingRow = $this->getModel()->fetchRow($query);

        try{
            if(!$shippingRow){
                throw new Exception("shipping row not found" , 1);
            }
            
            $this->setShipping($shippingRow);
        }
        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->getTemplate("shipping/edit.phtml");
    }

    public function updateAction(){
        $this->getMessage()->getSession()->start();
        $shipping = $this->getRequest()->getPost('shipping');

        try{
            if(!$shipping){
                throw new Exception("data not found" , 1);
            }
            else{
                $this->getMessage()->addMessages("data updated success fully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dataTime = date("Y-m-d h:i:sA");
            $shipping['updated_at'] = $dataTime;
        }
        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }


        $shippingId = $this->getRequest()->getParam('id');
        try{
            if(!$shippingId){
                throw new Exception("shipping id not found");
            }

            $condition['shipping_method_id'] = $shippingId;
            $this->getModel()->update($shipping , $condition);
        }
        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('shipping', 'grid', [] , true);
    }

    public function deleteAction(){
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');

        try{
            if(!$deleteId){
                throw new Exception("Delete id not found" , 1);
            }
            else{
                $this->getMessage()->addMessages("Row deleted successfully" , Model_Core_Message::SUCCESS);
            }

            $this->getModel()->delete($deleteId);
        }
        catch(Exception $e){
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('shipping', 'grid', [] , true);
    }
}

?>