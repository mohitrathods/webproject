<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';
require_once 'Model/Core/Url.php';

require_once 'Model/Core/Message.php';
require_once 'Model/Core/Table/Row.php';

class Controller_Product extends Contoller_Core_Action{

    protected $product = [];

    protected $productId = null;

    protected $model = null;

    protected $productUrl = null;

    protected $row = null;

    //---------- setter getter product url

    public function setProductUrl($productUrl){
        $this->productUrl = $productUrl;
        return $this;
    }

    public function getProductUrl(){
        if($this->productUrl){
            return $this->productUrl;
        }

        $productUrl = new Model_Core_Url();
        $this->setProductUrl($productUrl);
        return $productUrl;
    }

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
    public function setRow($row){
        $this->row = $row;
        return $this;
    }

    public function getRow(){
        if($this->row){
            return $this->row;
        }
        $row = new Model_Core_Table_Row();
        $this->setRow($row);
        return $row;
    }

    //---------------------------------------------------------------

    public function gridAction(){
        // $query = "SELECT * FROM `product` WHERE 1";
        // $product = $this->getModel()->fetchAll($query);

        // $this->setProduct($product);

        // $this->getTemplate("product/grid.phtml");

        try {
            $this->getMessage()->getSession()->start();
            $query = "SELECT * FROM `product` WHERE 1";
            $product = $this->getModel()->fetchAll($query);
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

        // $product = $this->getRequest()->getPost('product'); 

        // date_default_timezone_set("Asia/kolkata");
		// $dateTime = date("Y-m-d h:i:sA");
		// $product['created_at'] = $dateTime;

        // $this->getModel()->insert($product);
        try {
            $this->getMessage()->getSession()->start();
            $product = $this->getRequest()->getPost('product');
            
            date_default_timezone_set("Asia/Kolkata");
            $datetime = date('y-m-d h:i:sA');
            $product['created_at'] = $datetime;

            $this->getModel()->insert($product);
            
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
        // $this->redirect("index.php?c=product&a=grid");
    }

    public function editAction(){
        // $query = "SELECT * FROM `product` WHERE `product_id` = {$this->getRequest()->getParam('id')}";
        // $productRow = $this->getModel()->fetchRow($query);

        // $this->setProduct($productRow);

       try {
        $this->getMessage()->getSession()->start();
        $productId = $this->getRequest()->getParam('id');
        $query = "SELECT * FROM `product` WHERE `product_id` = $productId";
        $productRow = $this->getModel()->fetchRow($query);

        if(!$productId){
            throw new Exception("id not found", 1);
        }
        else{
            $this->getMessage()->addMessages("id found" , Model_Core_Message::SUCCESS);
        }

        if(!$productRow){
            throw new Exception("id not found" ,  1);
        }
        else{
            $this->getMessage()->addMessages("ID found here is fetched row" , Model_Core_Message::SUCCESS);
        }
       
        $this->setProduct($productRow);

        
       } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
       } 

        $this->getTemplate("product/edit.phtml");
    }

    public function updateAction(){
        // $productRow = $this->getRequest()->getPost('product');

        // date_default_timezone_set("Asia/Kolkata");
        // $dateTime = date("Y-m-d h:i:sA");
        // $productRow['updated_at'] = $dateTime;

        // $productId = $this->getRequest()->getParam('id');

        // $condition['product_id'] = $productId;

        // $this->getModel()->update($productRow,$condition);

        try {
            $this->getMessage()->getSession()->start();
            $productRow = $this->getRequest()->getPost('product');

            if(!$productRow){
                throw new Exception("data update operation fail",1);
            }
            else {
                $this->getMessage()->addMessages('Data updated successfully' , Model_Core_Message::SUCCESS); 
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $productRow['updated_at'] = $dateTime;

            $productId = $this->getRequest()->getParam('id');
            $condition['product_id'] = $productId;

            $this->getModel()->update($productRow,$condition);

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->redirect('product','grid',[],true);
        // $this->redirect("index.php?c=product&a=grid");
    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');
        $this->getModel()->delete($deleteId);

        try {
            $this->getMessage()->getSession()->start();
            $deleteId = $this->getRequest()->getParam('id');

            if(!$deleteId){
                throw new Exception("data is not deleted" , 1);
            }
            else {
                $this->getMessage()->addMessages("data deleted successfully" , Model_Core_Message::SUCCESS);
            }

            $this->getModel()->delete($deleteId);

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }
        
        $this->redirect('product','grid',[],true);
        // $this->redirect("index.php?c=product&a=grid");
    }
    
}
?>