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

    public function addAction(){
        $this->getTemplate("customer/add.phtml");
    }

    public function insertAction(){
        $customer = $this->getRequest()->getPost('customer');

        date_default_timezone_set("Asia/Kolkata");
        $dateTime = date("Y-m-d h:i:sA");
        $customer['created_at'] = $dateTime;
        
        $this->getModel()->insert($customer);

        $this->redirect("index.php?c=customer&a=grid");

    }

    public function editAction(){

        $query = "SELECT * FROM `customer` WHERE `customer_id` = '{$this->getRequest()->getParam('id')}'";

        $customerRow = $this->getModel()->fetchRow($query);

        $this->setCustomer($customerRow);

        $this->getTemplate("customer/edit.phtml");
    }

    public function updateAction(){
        $customer = $this->getRequest()->getPost('customer'); //$_POST > customer array

        date_default_timezone_set("Asia/Kolkata");
        $dateTime = date("Y-m-d h:i:sA");
        $customer['updated_at'] = $dateTime;

        $customerId = $this->getRequest()->getParam('id');

        $condition['customer_id'] = $customerId;
        
        $this->getModel()->update($customer, $condition);

        $this->redirect("index.php?c=customer&a=grid");
    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');

        $this->getModel()->delete($deleteId);

        $this->redirect("index.php?c=customer&a=grid");
    }
}
?>