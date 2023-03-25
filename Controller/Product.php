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

    




    //-------- setter getter of row
    // public function testAction(){
    //     $row = new Model_Core_Table_Row();
    //     // $array['name'] = "mohit";
    //     // $array['email'] = "amc@gmail.com";
    //     // echo "<pre>";

    //     // $row->setData($array);
    //     // print_r($row->getData('email'));
    //     // print_r($row);

    //     // print_r($row->addData("new","newwww"));

    //     $row->email = 'mohit@mgsd.com';
    //     $row->name = 'mohit';
    //     $row->phone = '2356234';
    //     $row->gender = 'alpha male';
    //     $row->email = 'mohit';
    //     print($row);

    //     $row->save();
    //     die();

        
    // }

    //--------- 24 MARCH
    public function testAction(){
        // echo "<pre>";

        // $row = new Model_Core_Table_Row();
        // // print_r($productRow);
        // $product = $row->load(2);
        // // $product = $row->fetchAll(); //gets array
        // print_r($product);
        // // print_r($row->name);
        // print_r($this);
        // //$row is $this > $this : returns $row > $row = $this
        
        // //load function ma 4 data variable ma store karavya and return $this aakho atle 4 variable
        // //return krse object ni andar so aakho object male emathi jotu hoy e lai levu
        // $products = [$product, $product, $product, $product];
        // print_r($products);

        // //save method ma data malse 

        

    }

    //---------------------------------------------------------------

    public function gridAction(){
        // $query = "SELECT * FROM `product` WHERE 1";
        // $product = $this->getModel()->fetchAll($query);

        // $this->setProduct($product);

        try {
            $this->getMessage()->getSession()->start();
            $query = "SELECT * FROM `product` WHERE 1";
            $product = $this->getModel()->fetchAll($query);
            $this->setProduct($product);

            if(!$product){
                throw new Exception("Data not found",1);
            }
        } 
        catch (Exception $object) {
            $this->getMessage()->addMessages($object->getMessage(), Model_Core_Message::FAILURE);
        }

        //----------------------------------------- urls
        $urlClass= new Model_Core_Url();
        // print_r($urlClass->getUrl());
        // print_r($urlClass->getUrl());
        // print_r($this);

      

        // $url = new Model_Core_Url();
        // echo $url->getUrl();
		// $url->getUrl(null,'customer');
		// $url->getUrl();
		// $url->getUrl('edit', null);
		// $url->getUrl('customer', 'edit', ['id' => '5', 'tab' => 'address'] );
		// $url->getUrl('customer', 'edit', ['tab' => 'address'] );
		// $url->getUrl('customer', 'edit', ['id' =>null, 'tab' => 'address'] );
		// $url->getUrl('edit', 'customer', ['id' => null, 'tab' => 'address']);
		// $url->getUrl('edit', 'customer', ['tab' => 'address']);
		// $url->getUrl('edit', 'customer', ['id' => 5, 'tab' => 'null']);
		// print_r($url);
		// die();
        //----------------------------------------- urls


        $this->getTemplate("product/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("product/add.phtml");
    }

    public function insertAction(){
        $product = $this->getRequest()->getPost('product'); 

        date_default_timezone_set("Asia/kolkata");
		$dateTime = date("Y-m-d h:i:sA");
		$product['created_at'] = $dateTime;

        $this->getModel()->insert($product);

        //this product controller extends action so redirect
        $this->redirect(null,'grid');

		// $this->redirect(null,'sdv');

        
        // $this->redirect("index.php?c=product&a=grid");
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

        $this->redirect(null,'grid',[],true);
        // $this->redirect("index.php?c=product&a=grid");
    }

    public function deleteAction(){
        $deleteId = $this->getRequest()->getParam('id');
        $this->getModel()->delete($deleteId);
        
        $this->redirect(null,'grid',[],true);
        // $this->redirect("index.php?c=product&a=grid");
    }
    
}
?>