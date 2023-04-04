<?php
require_once 'Controller/Core/Action.php';

class Controller_Product extends Contoller_Core_Action {

    public function gridAction() {
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `product`";
        $products = Ccc::getModel('Product_Row')->fetchAll($query);

        try {
            if(!$products){
                throw new Exception("product data not found" ,1);
            }

            $this->getView()->setTemplate('product/grid.phtml')->setData(['products' => $products])->render();
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }
    }

    public function addAction() {
        $productRow = Ccc::getModel('Product_Row');
        $this->getView()->setTemplate('product/edit.phtml')->setData(['products' => $productRow])->render();
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $productRow = Ccc::getModel('Product_Row')->load($id);

        try {
            if(!$id){
                throw new Exception("data not found",1);
            }

            $this->getView()->setTemplate('product/edit.phtml')->setData(['products' => $productRow])->render();
        } 
        catch (Exception $e) {
            Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }
        
    }

    // 
    
    public function saveAction(){
        $this->getMessage()->getSession()->start();
        $id = $this->getRequest()->getParam('id');

        if(!$id){
            //add
            $addProduct = $this->getRequest()->getPost('product');

            try {
                if(!$addProduct){
                    throw new Exception("data not inserted",1);
                }

                else{
                    $row = Ccc::getModel('Product_Row')->setData($addProduct);
                    date_default_timezone_set("Asia/Kolkata");
                    $datetime = date("Y:m:d h:i:sA");
                    $row->created_at = $datetime;
                    $row->save();                    
                    Ccc::getModel('Core_Message')->addMessages("data inserted successfully",Model_Core_Message::SUCCESS);
                }
            } 
            catch (Exception $e) {
                Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
            }
        }
        else{
            //update
            $updateProduct = $this->getRequest()->getPost('product');

            try {
                if(!$updateProduct){
                    throw new Exception("data not updated",1);
                }

                else{
                    $row = Ccc::getModel('Product_Row')->setData($updateProduct);
                    date_default_timezone_set("Asia/Kolkata");
                    $datetime = date("Y:m:d h:i:sA");
                    $row->created_at = $datetime;
                    $row->save();

                    Ccc::getModel('Core_Message')->addMessages("data updated successfully", Model_Core_Message::SUCCESS);
                }
            } 
            catch (Exception $e) {
                Ccc::getModel('Core_Message')->addMessages($e->getMessage() ,Model_Core_Message::FAILURE);
            }
        }

        $this->redirect('product', 'grid',[],true);
    }

    public function deleteAction() {
        Ccc::getModel('Core_Message')->getSession()->start();
        $deleteId = $this->getRequest()->getParam('id');

        try {
            if(!$deleteId){
                throw new Exception("delete id not found data not deletd",1);
            }
            else{
                Ccc::getModel('Product_Row')->load($deleteId)->delete();
                Ccc::getModel('Core_Message')->addMessages("data deleted successfully",Model_Core_Message::SUCCESS);
            }
        } 
        catch (Exception $e) {
            Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

        $this->redirect('product', 'grid',[],true);

    }
}
?>