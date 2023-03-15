<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';

class Controller_Category extends Contoller_Core_Action{

    protected $category = [];
    protected $categoryId = null;
    protected $model = null;

    //------------ setter getter category
    public function setCategory($category){
        $this->category = $category;
        return $this;
    }
    
    public function getCategory(){
        return $this->category;
    }

    //------------ setter getter categoryID

    //-------------------------- setter getter of model

    // public function setModel($model){
    //     $this->model = $model;
    //     return $this;
    // }

    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Core_Table();
        $this->model = $model;
        return $model;
    }


    public function gridAction(){
        $query = "SELECT * FROM `category` WHERE 1";
        $category = $this->getModel()->fetchAll($query);
        
        $this->setCategory($category);

        $this->getTemplate("category/grid.phtml");

    }

    public function addAction(){
        echo "ADD ACTION OF category";
    }

    public function insertAction(){
        echo "insert ACTION OF category";
    }

    public function editAction(){
        echo "edit ACTION OF category";
    }

    public function updateAction(){
        echo "update ACTION OF category";
    }

    public function deleteAction(){
        echo "delete ACTION OF category";
    }
}
?>