<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';
require_once 'Model/Core/Url.php';

require_once 'Model/Core/Message.php';
require_once 'Model/Product/Row.php';
require_once 'Model/Core/Table/Row.php';


class Controller_Product extends Contoller_Core_Action{

    protected $product = [];

    protected $productId = null;

    protected $model = null;

    protected $modelProductRow = null;


    //------------------------- set & get Model
    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    public function getModel(){
        //get access to model class
        if($this->model){
            return $this->model;
        }
        $model = new Model_Product();
        $this->setModel($model);
        return $model;
    }

    //------------------------- set & get product ID
    public function setProductId($product){
        $this->productId = $product;
        return $this;
    }

    public function getProductId(){
        return $this->productId;
    }    

    //------------------------- set & get product 
    public function setProduct($product){
        $this->product = $product;
        return $this;
    }

    public function getProduct(){
        return $this->product;
    }

    //------------------------ setter getter of row
    public function setModelProductRow($modelproductrow){
        $this->modelProductRow = $modelproductrow;
        return $this;
    }

    public function getModelProductRow(){
        if($this->modelProductRow){
            return $this->modelProductRow;
        }

        $modelProductRow = new Model_Product_Row();
        $this->setModelProductRow($modelProductRow);
        return $modelProductRow;
    }

    //---------------------------------------------------------------

    public function gridAction(){
        // $this->getMessage()->getSession()->start();

        try {
            $query = "SELECT * FROM `product` WHERE 1";
            $product = $this->getModelProductRow()->fetchAll($query);
            if(!$product){
                throw new Exception("Data not found", 1);
            }
            $this->setProduct($product);
        

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->getTemplate("product/grid.phtml");

    }

    public function addAction(){
        $this->getTemplate("product/add.phtml");
    }

    public function insertAction(){
        try {
            $product = $this->getRequest()->getPost('product');
            
            date_default_timezone_set("Asia/Kolkata");
            $datetime = date('y-m-d h:i:sA');
            $this->getModelProductRow()->setData($product);
            $this->getModelProductRow()->created_at = $datetime;
            $this->getModelProductRow()->save();
            
            if(!$product){
                throw new Exception("data not inserted");
            }
            else {
                $this->getMessage()->addMessages('Data added successfully' , Model_Core_Message::SUCCESS);
            }

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }
        
        
        $this->redirect('product','grid');
    }

    public function editAction(){
       try {
        $productId = $this->getRequest()->getParam('id');
        $query = "SELECT * FROM `product` WHERE `product_id` = $productId";
        $productRow = $this->getModelProductRow()->load($productId);

        if(!$productId){
            throw new Exception("id not found", 1);
        }

        if(!$productRow){
            throw new Exception("id not found" ,  1);
        }
       
        $this->setProduct($productRow);
        
       } 
       catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
       } 

        $this->getTemplate("product/edit.phtml");
    }

    public function updateAction(){

        try {
            $productRow = $this->getRequest()->getPost('product');
            // print_r($productRow);die();

            if(!$productRow){
                throw new Exception("data update operation fail",1);
            }
            else {
                $this->getMessage()->addMessages('Data updated successfully' , Model_Core_Message::SUCCESS); 
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");

            $productId = $this->getRequest()->getParam('id');
            $this->getModelProductRow()->setData($productRow);
            $this->getModelProductRow()->product_id = $productId;
            $this->getModelProductRow()->updated_at = $dateTime;
            $this->getModelProductRow()->save();

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->redirect('product','grid',[],true);
    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');
            
        try {
            if(!$deleteId){
                throw new Exception("data is not deleted" , 1);
            }
            else {
                $this->getMessage()->addMessages("data deleted successfully" , Model_Core_Message::SUCCESS);
            }

            $this->getModelProductRow()->load($deleteId);
            $this->getModelProductRow()->delete();

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }
        
        $this->redirect('product','grid',[],true);
    }
    
}
?>