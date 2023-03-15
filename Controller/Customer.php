<?php 
require_once 'Model/Customer.php';
require_once 'Controller/Core/Action.php';
class Controller_Customer extends Contoller_Core_Action{

    protected $customer = [];

    protected $customerId = null;

    protected $model = null;

    //------------- getter setter for set custoemr
    public function setCustomer($customer){
        $this->customer = $customer;
        return $this;
    }

    public function getCustomer(){
        return $this->customer;
    }

    //------------- getter setter for model

    // public function setModel($model){
    //     $this->model = $model;
    //     return $this;
    // }
    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Customer();
        $this->model = $model;
        return $model;
    }

    
    public function gridAction(){
         $query = "SELECT * FROM `customer` WHERE 1";
        $customer = $this->getModel()->fetchAll($query);
        
        $this->setCustomer($customer);

        $this->getTemplate("customer/grid.phtml");
        
    }
}
?>