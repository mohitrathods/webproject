
<?php

require_once 'Controller/Core/Action.php';

class Controller_Product_Media extends Contoller_Core_Action {

    public function gridAction(){
        Ccc::getModel('Core_Session')->start();

        try {
            $grid = new Block_Product_Media_Grid();
            $this->getLayout()->getChild('content')->addChild('grid',$grid);
            $grid->getCollection();
            $this->getLayout()->render();
        } 
        catch (Exception $e) {
            
        }
    }
    

    public function addAction(){
        Ccc::getModel('Core_Session')->start();

        $add = new Block_Product_Media_Edit();
        $this->getLayout()->getChild('content')->addChild('add',$add);
        $add->getCollection();
        $this->getLayout()->render();
    }

    public function insertAction(){
        $productId = Ccc::getModel('Core_Request')->getParam('id');
        $mediaPost = Ccc::getModel('Core_Request')->getPost('media');

        //insert data
        $mediaPost->product_id = $productId;
        $insertData = Ccc::getModel('Product_Media')->setData($mediaPost);
        $insertData->save();

        // change file name
            $get_files = $_FILES['image'];

            $extension = explode('.',$_FILES['image']['name']);

            $file_name = $insertData.'.'.$extension[1]; //new file name

            $image['image'] = $file_name;

            $condition['media_id'] = $insertData;
            $condition['product_id'] = $productId;

            //update filename
            $update = Ccc::getModel('Product_Media')->setData($image,$condition);
            $update->save();

            move_uploaded_file($_FILES['image']['tmp_name'],"images/".$file_name);



    }
    

}

?>
