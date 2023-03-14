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
        echo "this is GRID OF VENDOR";
        $this->getModel()->setTableName("vendor");

        $vendor = $this->getModel()->fetchAll();
        $this->setVendor($vendor);

        $this->getTemplate("vendor/grid.phtml");
    }


}

?>