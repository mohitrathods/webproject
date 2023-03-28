<?php 
require_once 'Model/Customer.php';
require_once 'Controller/Core/Action.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Message.php';
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

    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Customer();
        $this->model = $model;
        return $model;
    }

    
    public function gridAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `customer` WHERE 1";
        $customer = $this->getModel()->fetchAll($query);

        try {
            if(!$customer){
                throw new Exception("data not found" , 1);
            }

            $this->setCustomer($customer);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->getTemplate("customer/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("customer/add.phtml");
    }

    public function insertAction(){
        $this->getMessage()->getSession()->start();
        $customer = $this->getRequest()->getPost('customer');
        
        try {
            if(!$customer){
                throw new Exception("Data not inserted" , 1);
            }
            else{
                $this->getMessage()->addMessages("customer added successfully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $customer['created_at'] = $dateTime;
            $this->getModel()->insert($customer);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('customer', 'grid');
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `customer` WHERE `customer_id` = '{$this->getRequest()->getParam('id')}'";
        $customerRow = $this->getModel()->fetchRow($query);

        try {
            if(!$customerRow){
                throw new Exception("row not found" , 1);
            }

            $this->setCustomer($customerRow);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->getTemplate("customer/edit.phtml");
    }

    public function updateAction(){
        $this->getMessage()->getSession()->start();
        $customer = $this->getRequest()->getPost('customer'); //$_POST > customer array

        try {
            if(!$customer){
                throw new Exception("customer row not found" , 1);
            }
            else{
                $this->getMessage()->addMessages("data updated successfully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $customer['updated_at'] = $dateTime;
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }


        $customerId = $this->getRequest()->getParam('id');

        try {
            if(!$customerId){
                throw new Exception("custoemr id not found" , 1);
            }
        
            $condition['customer_id'] = $customerId;
            $this->getModel()->update($customer, $condition);    
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('customer', 'grid' , [] , true);
    }

    public function deleteAction(){
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');

        try {
            if(!$deleteId){
                throw new Exception("data id not found" , 1);
            }
            else{
                $this->getMessage()->addMessages("data deleted successfully" , Model_Core_Message::SUCCESS);
            }

            $this->getModel()->delete($deleteId);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('customer', 'grid' , [] , true);
    }
}
?>