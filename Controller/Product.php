<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';

echo "this is product controller";
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

        $query = "SELECT * FROM `product` WHERE 1";
        $product = $this->getModel()->fetchAll($query);

        $this->setProduct($product);

        $this->getTemplate("product/grid.phtml");

    }

    public function addAction(){
        $this->getTemplate("product/add.phtml");
    }

    public function insertAction(){
        $product = $this->getRequest()->getPost('product'); //from $_POST('product') give array of product

        $this->getModel()->insert($product);
        
    }

    public function editAction(){
        
        $query = "SELECT * FROM `product` WHERE `product_id` = {$this->getRequest()->getParam('id')}";
        $productRow = $this->getModel()->fetchRow($query);

        $this->setProduct($productRow);

        $this->getTemplate("product/edit.phtml");
    }

    public function updateAction(){
        echo "This is update action when click on submit button";

        $productRow = $this->getRequest()->getPost('product');
        $this->getModel()->update($productRow);
    }

    public function deleteAction(){
        echo "This is delete action when click on delete button";
        
    }
}
?>