<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';
require_once 'Model/Core/Url.php';

require_once 'Model/Core/Message.php';
// require_once 'Model/Product/Row.php';
require_once 'Model/Core/Table/Row.php';



class Controller_Product extends Contoller_Core_Action{

    protected $product = [];

    protected $productId = null;

    protected $model = null;

    // protected $modelProductRow = null;


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
    // public function setModelProductRow($modelproductrow){
    //     $this->modelProductRow = $modelproductrow;
    //     return $this;
    // }

    // public function getModelProductRow(){
    //     if($this->modelProductRow){
    //         return $this->modelProductRow;
    //     }

    //     $modelProductRow = new Model_Product_Row();
    //     $this->setModelProductRow($modelProductRow);
    //     return $modelProductRow;
    // }

    //---------------------------------------------------------------

    public function gridAction(){
        $this->getMessage()->getSession()->start();

        try {
            $query = "SELECT * FROM `product` WHERE 1";
            $product = Ccc::getModel('Product_Row')->fetchAll($query);
            // $product = $this->getModelProductRow()->fetchAll($query);
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
        $this->getMessage()->getSession()->start();

        try {
            $product = $this->getRequest()->getPost('product');
            print_r($product);
            
            date_default_timezone_set("Asia/Kolkata");
            $datetime = date('y-m-d h:i:sA');
            // $this->getModelProductRow()->setData($product);
            // $this->getModelProductRow()->created_at = $datetime;
            // $this->getModelProductRow()->save();
            
            $x = Ccc::getModel('Product_Row')->setData($product);
            print_r($x);
            $y = Ccc::getModel('Product_Row')->getData();
            print_r($y);
            Ccc::getModel('Product_Row')->created_at = $datetime;
            Ccc::getModel('Product_Row')->save();         
            
            print_r($product);
            
            if(!$product){
                throw new Exception("data not inserted");
            }
            else {
                $this->getMessage()->addMessages('Data added successfully' , Model_Core_Message::SUCCESS);
            }

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }
        
        
        // $this->redirect('product','grid');
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();

       try {
        $productId = $this->getRequest()->getParam('id');
        $query = "SELECT * FROM `product` WHERE `product_id` = $productId";
        $productRow = Ccc::getModel('Product_Row')->load($productId);

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
        $this->getMessage()->getSession()->start();

        try {
            $productRow = $this->getRequest()->getPost('product');
            // print_r($productRow);

            if(!$productRow){
                throw new Exception("data not posted" , 1);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");

            $productId = $this->getRequest()->getParam('id');
            Ccc::getModel('Product_Row')->setData($productRow);
            Ccc::getModel('Product_Row')->product_id = $productId;
            Ccc::getModel('Product_Row')->updated_at = $dateTime;
            $result = Ccc::getModel('Product_Row')->save();
            // print_r($result);

            if(!$result){
                throw new Exception("data update operation fail",1);
            }
            else {
                $this->getMessage()->addMessages('Data updated successfully' , Model_Core_Message::SUCCESS); 
            }
        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->redirect('product','grid',[],true);
    }

    public function deleteAction(){
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');
            
        try {
            if(!$deleteId){
                throw new Exception("data is not deleted" , 1);
            }
            else {
                $this->getMessage()->addMessages("data deleted successfully" , Model_Core_Message::SUCCESS);
            }

            Ccc::getModel('Product_Row')->load($deleteId);
            Ccc::getModel('Product_Row')->delete();

        } catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }
        
        $this->redirect('product','grid',[],true);
    }
    
}
?>