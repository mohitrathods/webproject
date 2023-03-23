<?php
require_once 'Controller/Core/Action.php';
require_once 'Model/Product.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Session.php';
require_once 'Model/Core/Message.php';
require_once 'Model/Core/Table/Row.php';

class Controller_Product extends Contoller_Core_Action{

    protected $product = [];

    protected $productId = null;

    protected $model = null;

    protected $message = null;

    //-------- setter getter of row
    public function testAction(){
        $row = new Model_Core_Table_Row();
        // $array['name'] = "mohit";
        // $array['email'] = "amc@gmail.com";
        // echo "<pre>";

        // $row->setData($array);
        // print_r($row->getData('email'));
        // print_r($row);

        // print_r($row->addData("new","newwww"));

        $row->email = 'mohit@mgsd.com';
        $row->name = 'mohit';
        $row->phone = '2356234';
        $row->gender = 'alpha male';
        $row->email = 'mohit';
        print($row);

        $row->save();
        die();

        //to remove unset it 
        // $row->removeData("email");
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
        $this->model = $model;
        return $model;
    }

    //------------------ message getter setter

    // public function setMessage($message){
    //     $this->message = $message;
    //     return $this;
    // }

    // public function getMessage(){
    //     if($this->message){
    //         return $this->message;
    //     }

    //     $message = new Model_Core_Message();
    //     $this->message = $message;
    //     retrun $message;
    // }

    


    //---------------------------------------------------------------

   

    public function gridAction(){

        // echo "<pre>";
        // $session = new Model_Core_Session();
        // $session->start()->getId();
        // $session->set('name','mohit')->set("email","rms@gmail.com")->set("id","111");
        // print_r($_SESSION);

        

        // try {
            // echo "<pre>";
            // $message = new Model_Core_Message();
            // $message->getSession();
            // print_r($message);
            // $message->addMessage("product added","success");
            // $message->addMessage("product fail","failure");
            // $message->clearMessage();
            // $message->addMessage("product notice","notice");
            // print_r($_SESSION);
        // }

        // catch{

        // }

        // try{
        //     $query = "SELECT * FROM `product` WHERE 1";
        //     $product = $this->getModel()->fetchAll($query);
        //     $this->setProduct($product);

        //     if($product){
        //         $this->getMessage()->getSession()->start();

        //     }
        // }
        

        // die();


        $query = "SELECT * FROM `product` WHERE 1";
        $product = $this->getModel()->fetchAll($query);

        $this->setProduct($product);

        $this->getTemplate("product/grid.phtml");

        
    }

    public function addAction(){
        // print_r($this->getRequest()->getPost());
        // print_r($this->getRequest()->getParam());
        $this->getTemplate("product/add.phtml");
    }

    public function insertAction(){

        echo "<pre>";

        // print_r($this->getRequest()->getPost());
        // print_r($this->getRequest()->getParam());

        $product = $this->getRequest()->getPost('product'); 

        date_default_timezone_set("Asia/kolkata");
		$dateTime = date("Y-m-d h:i:sA");
		$product['created_at'] = $dateTime;

        $this->getModel()->insert($product);
        
        $this->redirect("index.php?c=product&a=grid");

    }

    public function editAction(){

        // print_r($this->getRequest()->getPost());
        // print_r($this->getRequest()->getParam());
        
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