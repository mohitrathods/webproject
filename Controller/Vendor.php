<?php

require_once 'Model/Vendor.php';
require_once 'Controller/Core/Action.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Message.php';


class Controller_Vendor extends Contoller_Core_Action{
    protected $vendor = [];

    protected $vendorId = null;

    protected $model = null;

    //-------------- getter setter of vendor
    public function setVendor($vendor){
        $this->vendor = $vendor;
        return $this;
    }

    public function getVendor(){
        return $this->vendor;
    }
    
    //-------------- getter setter of model
    
    public function setModel($model){
        $this->model = $model;
        return $this;
    }
    
    public function getModel(){
        if($this->model){
            return $this->model;
        }   
        $model = new Model_Vendor();
        $this->model = $model;
        return $model;
    }

    public function gridAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `vendor` WHERE 1";
        $vendor = $this->getModel()->fetchAll($query);

        try {
            if(!$vendor){
                throw new Exception("data not found", 1);
            }
            
            $this->setVendor($vendor);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->getTemplate("vendor/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("vendor/add.phtml");
    }

    public function insertAction(){
        $this->getMessage()->getSession()->start();
        $vendor = $this->getRequest()->getPost('vendor');

        try {
            if(!$vendor){
                throw new Exception("vendor data not found",1);
            }
            else {
                $this->getMessage()->addMessages("vendor inserted successfully" ,Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $vendor['created_at'] = $dateTime;
            $this->getModel()->insert($vendor);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }   

        $this->redirect('vendor', 'grid');
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `vendor` WHERE `vendor_id` = '{$this->getRequest()->getParam('id')}'";
        $vendorRow = $this->getModel()->fetchRow($query);

        try {
            if(!$vendorRow){
                throw new Exception("vendor row not found" , 1);
            }

            $this->setVendor($vendorRow);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->getTemplate("vendor/edit.phtml");
    }

    public function updateAction(){
        $this->getMessage()->getSession()->start();
        $vendor = $this->getRequest()->getPost('vendor');

        try {
            if(!$vendor){
                throw new Exception("data not inserted" , 1);
            }
            else {
                $this->getMessage()->addMessages("data updated successfully" , Model_Core_Message::SUCCESS);
            }

        date_default_timezone_set("Asia/Kolkata");
        $dateTime = date("Y-m-d h:i:sA");
        $vendor['updated_at'] = $dateTime;
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }
        

        $vendorId = $this->getRequest()->getParam('id');

        try {
            if(!$vendorId){
                throw new Exception("vendor id not found" , 1);
            }

            $condition['vendor_id'] = $vendorId;
            $this->getModel()->update($vendor , $condition);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('vendor', 'grid', [], true);
    }

    public function deleteAction(){
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');

        try {
            if(!$deleteId){
                throw new Exception("delete id not found" , 1);
            }
            else {
                $this->getMessage()->addMessages("data deleted successfully" , Model_Core_Message::SUCCESS);
            }

            $this->getModel()->delete($deleteId);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('vendor', 'grid', [], true);
    }
}

?>