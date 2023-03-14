<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';

echo "this is product controller";
class Controller_Product extends Contoller_Core_Action{

    protected $product = [];

    protected $productId = null;

    protected $model = null;

    //------------------------- set & get product
    public function setProduct($parameter){
        $this->product = $parameter;
        return $this;
    }

    public function getProduct(){
        return $this->product;
    }

    //------------------------- set & get product ID
    public function setProductId($parameter){
        $this->productId = $parameter;
        return $this;
    }

    public function getProductId(){
        return $this->productId;
    }

    //------------------------- set & get Model
    public function setModel($parameter){
        $this->model = $parameter;
        return $this;
    }

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
        echo "this is grid page and grid Action";
        //get direct data here
        $this->getModel()->setTableName("product");
        $product = $this->getModel()->fetchAll();
        $this->setProduct($product);

        // require_once "View/Product/grid.phtml";

        $this->getTemplate("product/grid.phtml");
        // $this->redirect("index.php?c=product&a=grid");

    }

    public function addAction(){
        echo "this is add page and add action";
    }

    public function insertAction(){
        echo "this is insert action when click on submit";
    }

    public function editAction(){
        echo "this is edit page and edit action";
    }

    public function updateAction(){
        echo "This is update action when click on submit button";
    }

    public function deleteAction(){
        echo "This is delete action when click on delete button";
    }
}
?>