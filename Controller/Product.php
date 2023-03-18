<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';
require_once 'Model/Core/Url.php';


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

        // $url = new Model_Core_Url();
        // $url->getCurrentUrl();
        // echo $url->getController();
        // echo $url->getUrl(); //current url
        // echo $url->getUrl('category','add',['name'=>'mohit','email'=>'email','id'=>1]);
        // echo $url->getUrl(null, null,['id'=>5]); 
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
        $this->getModel()->update($productRow);

        $this->redirect("index.php?c=product&a=grid");
    }

    public function deleteAction(){
        
        $deleteId = $this->getRequest()->getParam('id');
        $this->getModel()->delete($deleteId);
        
        $this->redirect("index.php?c=product&a=grid");
    }
    
}
?>