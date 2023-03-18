<?php
require_once 'Controller/Core/Action.php';

require_once 'Model/Product/Media.php';

class Controller_Product_Media extends Contoller_Core_Action{
    
    protected $model = null;

    protected $media = [];

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
        $model = new Model_Core_Table();
        $this->model = $model;
        return $model;
    }


    public function gridAction(){
        $query = "SELECT * FROM `product_media` WHERE `product_id` = {$this->getRequest()->getParam('id')}";
        
        $fetchedMedia = $this->getModel()->fetchAll($query);

        $this->getTemplate("Product_Media/grid.phtml");
        
    }

    public function addAction(){
        $this->getTemplate("Product_Media/add.phtml");
    }

    public function insertAction(){
        $mediaData = $this->getRequest()->getPost('media');

        $this->getModel()->insertMedia($mediaData);

        //redirect
    }
}
?>