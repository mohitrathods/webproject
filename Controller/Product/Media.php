<?php

require_once 'Model/Product/Media.php';
require_once 'Controller/Core/Action.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Table.php';
require_once 'Model/Core/Message.php';

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
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `product_media` WHERE `product_id` = {$this->getRequest()->getParam('id')}";
        $fetchedMedia = $this->getModel()->fetchAll($query);

        try {
            if(!$fetchedMedia){
                throw new Exception("data not found" , 1);
            }

            $this->setMedia($fetchedMedia);
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

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

        
        // $this->redirect("index.php?c=product_media&a=grid&id=$productId");
        $this->redirect('product_media','grid',['id' => $productId]);

    }

    public function updateAction(){

        echo "<pre>";

        $productId = $this->getRequest()->getParam('id');

        $result = $this->getRequest()->getPost();
        print_r($result);

        $baseId = $result['base'];
        $smallId = $result['small'];
        $thumbnailId = $result['thumbnail'];
        $galleryId = $result['gallery'];
        print_r($baseId);

        $resetId['base'] = 0;
        $resetId['small'] = 0;
        $resetId['thumbnail'] = 0;
        $resetId['gallery'] = 0;
        //reset named array and stored 0 all values
        $condition['product_id'] = $productId;
        // print_r($condition);
        //reset things
        $resetIDs = $this->getModel()->update($resetId,$condition);
        // print_r($resetIDs);
        
        
        
        $base['base'] = 1;
        $condition['media_id'] = $baseId;
        // print_r($condition);
        $resetIDs = $this->getModel()->update($base, $condition);

        $small['small'] = 1;
        $condition['media_id'] = $smallId;
        // print_r($condition);
        $resetIDs = $this->getModel()->update($small, $condition);

        $thumbnail['thumbnail'] = 1;
        $condition['media_id'] = $thumbnailId;
        // print_r($condition);
        $resetIDs = $this->getModel()->update($thumbnail, $condition);

        $gallery['gallery'] = 1;
        $condition['media_id'] = $galleryId;
        // print_r($condition);
        $resetIDs = $this->getModel()->update($gallery, $condition);

        // $this->redirect("index.php?c=product_media&a=grid&id=$productId");
        $this->redirect('product_media', 'grid' ,['id' => $productId]);
        

    }

    public function deleteAction(){
        echo "inside delete";
        $productId = $this->getRequest()->getParam('product_id');
		$mediaId = $this->getRequest()->getParam('media_id');
		$condition['product_id'] = $productId;
		$condition['media_id'] = $mediaId;

		$result = $this->getModel()->delete($condition);
		// $this->redirect($this->getUrlObj()->getUrl('product_media','grid', ['id' => $productId, 'media_id' => null]));

    }
}
?>