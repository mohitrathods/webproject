<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Session.php';

class Controller_Product extends Contoller_Core_Action{

    protected $product = [];

    protected $productId = null;

    protected $model = null;

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

    //------------------------- set & get Model
    // public function setModel($product){
    //     $this->model = $product;
    //     return $this;
    // }

    public function getModel(){
        //get access to model class
        if($this->model){
            return $this->model;
        }
        $model = new Model_Product();
        $this->model = $model;
        return $model;
    }


    //---------------------------------------------------------------

   

    public function gridAction(){

        // try {

        //     throw new Exception("Error Processing Request", 1);
        //     $_SESSION = [
        //         "message" => [
        //             "success" => null,
        //             "failure" => null,
        //             "notice" => null,
        //         ]
        //     ];
        //     print_r($_SESSION);
            
        // } 
        // catch (Exception $e1) {
        //     echo "<pre>";
        //     print_r($e1->getMessage());
        // }
        // die();

        $query = "SELECT * FROM `product` WHERE 1";
        $product = $this->getModel()->fetchAll($query);

        $this->setProduct($product);

        $this->getTemplate("product/grid.phtml");

        
    }

    public function addAction(){
        $this->getTemplate("product/add.phtml");
    }

    public function insertAction(){
        $product = $this->getRequest()->getPost('product'); //from $_POST('product','another array','array 3') give array of product

        date_default_timezone_set("Asia/kolkata");
		$dateTime = date("Y-m-d h:i:sA");
		$product['created_at'] = $dateTime;
        
        $this->getModel()->insert($product);
        
        $this->redirect("index.php?c=product&a=grid");

    }

    public function editAction(){
        
        $query = "SELECT * FROM `product` WHERE `product_id` = {$this->getRequest()->getParam('id')}";
        $productRow = $this->getModel()->fetchRow($query);

        $this->setProduct($productRow);

        $this->getTemplate("product/edit.phtml");

    }

    public function updateAction(){

        $productRow = $this->getRequest()->getPost('product');

        date_default_timezone_set("Asia/Kolkata");
        $dateTime = date("Y-m-d h:i:sA");
        $productRow['updated_at'] = $dateTime;

        $productId = $this->getRequest()->getParam('id');

        $condition['product_id'] = $productId;

        $this->getModel()->update($productRow,$condition);

        $this->redirect("index.php?c=product&a=grid");
    }

    public function deleteAction(){
        
        $deleteId = $this->getRequest()->getParam('id');
        $this->getModel()->delete($deleteId);
        
        $this->redirect("index.php?c=product&a=grid");
    }
    
}
?>