<?php
require_once 'Controller/Core/Action.php';

class Controller_Category extends Contoller_Core_Action{
    public function gridAction() {
        // Ccc::getModel('Core_Message')->getSession()->start();
        // $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `category`";
        $categories = Ccc::getModel('Category_Row')->fetchAll($query);
        // print_r($categories);
        $this->getView()->setTemplate('category/grid.phtml')->setData(['category' => $categories])->render();

    }


}
?>

<!-- 
require_once 'Controller/Core/Action.php';
require_once 'Model/Category.php';
require_once 'Model/Core/Url.php';

require_once 'Model/Core/Message.php';  
require_once 'Model/Core/Table/Row.php';

class Controller_Category extends Contoller_Core_Action{

    protected $category = [];

    protected $categoryId = null;

    protected $model = null;

    protected $row = null;

    //------------ setter getter category
    public function setCategory($category){
        $this->category = $category;
        return $this;
    }
    
    public function getCategory(){
        return $this->category;
    }

    //------------------------- set & get category ID
    public function setCategoryId($category){
        $this->categoryId = $category;
        return $this;
    }

    public function getCategoryId(){
        return $this->categoryId;
    }   

    //-------------------------- setter getter of model

    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Category();
        $this->model = $model;
        return $model;
    }

    //------------------ set get row
    


    //----------------------------
    public function gridAction(){
        
        $this->getMessage()->getSession()->start();

        try {
            $query = "SELECT * FROM `category` WHERE 1";
            $category = $this->getModel()->fetchAll($query);
            if(!$category){
                throw new Exception("data not found" ,1);
            }
            $this->setCategory($category);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->getTemplate("category/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("category/add.phtml");
    }

    public function insertAction(){
        $this->getMessage()->getSession()->start();
        $category = $this->getRequest()->getPost('category');

        try {
            if(!$category){
                throw new Exception("data not inserted",1);
            }
            else{
                $this->getMessage()->addMessages("category inserted successfully", Model_Core_Message::SUCCESS);
            }
            
            date_default_timezone_set('Asia/Kolkata');
            $dateTime = date("Y-m-d h:i:sA");
            $category['created_at'] = $dateTime;
            $this->getModel()->insert($category);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->redirect('category', 'grid');
    }

    public function editAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `category` WHERE `category_id` = '{$this->getRequest()->getParam('id')}'";
        $categoryRow = $this->getModel()->fetchRow($query);

        try {
            if(!$categoryRow){
                throw new Exception("row not found", 1);
            }

            $this->setCategory($categoryRow);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }


        $this->getTemplate("category/edit.phtml");
    }

    public function updateAction(){
        $this->getMessage()->getSession()->start();
        $category = $this->getModel()->getPost('category');

        try {
            if(!$category){
                throw new Exception("data not updated" , 1);
            }
            else{
                $this->getMessage()->addMessages("data updated successfully" , Model_Core_Message::SUCCESS);
            }

            date_default_timezone_set("Asia/Kolkata");
            $dateTime = date("Y-m-d h:i:sA");
            $category['updated_at'] = $dateTime;
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        
        $categoryId = $this->getRequest()->getParam('id');

        try {
            if(!$categoryId){
                throw new Exception("row id not found" , 1);
            }

            $condition['category_id'] = $categoryId;
            $this->getModel()->update($category,$condition);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        // $this->redirect('category', 'grid' , [] , true);
    }

    public function deleteAction(){
        $this->getMessage()->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');
        
        try {
            if(!$deleteId){
                throw new Exception("delete id not found", 1);
            }
            else{
                $this->getMessage()->addMessages("data deleted successfully", Model_Core_Message::SUCCESS);
            }
            $this->getModel()->delete($deleteId);

        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('category', 'grid', [], true);
    }
}
?> -->