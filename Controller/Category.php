<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Category.php';
// require_once 'Model/Core/Request.php';

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
        $model = new Model_Category();
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
        $this->getTemplate("category/add.phtml");
    }

    public function insertAction(){
        $category = $this->getRequest()->getPost('category');
        
        $this->getModel()->insert($category);

        $this->redirect("index.php?c=category&a=grid");
    }

    public function editAction(){

        $query = "SELECT * FROM `category` WHERE `category_id` = '{$this->getRequest()->getParam('id')}'";

        $categoryRow = $this->getModel()->fetchRow($query);

        $this->setCategory($categoryRow);

        $this->getTemplate("category/edit.phtml");
    }

    public function updateAction(){
        $category = $this->getModel()->getPost('category');
        // print_r($category);

        $this->getModel()->update($category);

        $this->redirect("index.php?c=category&a=grid");

    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');

        $this->getModel()->delete($deleteId);

        $this->redirect("index.php?c=category&a=grid");
    }
}
?>