<?php

require_once 'Model/Product/Media.php';
require_once 'Controller/Core/Action.php';

require_once 'Model/Core/Table.php';

class Controller_Product_Media extends Contoller_Core_Action{
    
    protected $model = null;

    protected $media = [];

    protected $mediaId = null;

    //---------------- media idi setter getter
    public function setMediaId($mediaId){
        $this->mediaId = $mediaId;
        return $this;
    }
    public function getMediaId(){
        return $this->mediaId;
    }
    

    //--------------------- media getter setter
    public function setMedia($media){
        $this->media = $media;
        return $this;
    }

    public function getMedia(){
        return $this->media;
    }

    //----------------- model getter setters
    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Product_Media();
        $this->model = $model;
        return $model;
    }


    public function gridAction(){
        $query = "SELECT * FROM `product_media` WHERE `product_id` = {$this->getRequest()->getParam('id')}";
        
        $fetchedMedia = $this->getModel()->fetchAll($query);

        $this->setMedia($fetchedMedia);
        $this->getTemplate("Product_Media/grid.phtml");

        
    }

    public function addAction(){

        $this->getTemplate("Product_Media/add.phtml");
    }

    public function insertAction(){

        echo "<pre>";
        $productId = $this->getRequest()->getParam('id');
        $mediaPost = $this->getRequest()->getPost();
        $mediaPost['product_id'] = $productId;

        //insert data
        $mediaId = $this->getModel()->insert($mediaPost);

        //change file name
        $get_files = $_FILES['image'];

        $extension = explode('.',$_FILES['image']['name']);

        $file_name = $mediaId.'.'.$extension[1]; //new file name

        $image['image'] = $file_name;

        $condition['media_id'] = $mediaId;
        $condition['product_id'] = $productId;

        //update filename
        $str = $this->getModel()->update($image,$condition);

        echo "<pre>";

        move_uploaded_file($_FILES['image']['tmp_name'],"images/".$file_name);

        
        $this->redirect("index.php?c=product_media&a=grid&id=$productId");

    }

    public function updateAction(){

        echo "<pre>";
        $result = $this->getRequest()->getPost();
        print_r($result);

        

    }

    public function deleteAction(){
        echo "inside delete";
    }
}
?>