<?php

require_once 'Model/Vendor.php';
require_once 'Controller/Core/Action.php';

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
    
    // public function setModel($model){
    //     $this->model = $model;
    //     return $this;
    // }
    public function getModel(){
        if($this->model){
            return $this->model;
        }   
        $model = new Model_Vendor();
        $this->model = $model;
        return $model;
    }

    public function gridAction(){
         $query = "SELECT * FROM `vendor` WHERE 1";
        $vendor = $this->getModel()->fetchAll($query);
        
        $this->setVendor($vendor);

        $this->getTemplate("vendor/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("vendor/add.phtml");
    }

    public function insertAction(){
        $vendor = $this->getRequest()->getPost('vendor');

        $this->getModel()->insert($vendor);

        $this->redirect("index.php?c=vendor&a=grid");
    }

    public function editAction(){

        $query = "SELECT * FROM `vendor` WHERE `vendor_id` = '{$this->getRequest()->getParam('id')}'";
        
        $vendorRow = $this->getModel()->fetchRow($query);

        $this->setVendor($vendorRow);

        $this->getTemplate("vendor/edit.phtml");
    }

    public function updateAction(){
        $vendor = $this->getRequest()->getPost('vendor');

        $this->getModel()->update($vendor);

        $this->redirect("index.php?c=vendor&a=grid");
    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');

        $this->getModel()->delete($deleteId);

        $this->redirect("index.php?c=vendor&a=grid");
    }
}

?>