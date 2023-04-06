<?php
require_once 'Controller/Core/Action.php';

class Controller_Admin extends Contoller_Core_Action{
    public function gridAction() {
        Ccc::getModel('Core_Session')->start();

        try {
            $adminGrid = new Block_Admin_Grid();
            $this->getLayout()->getChild('content')->addChild('grid', $adminGrid);
            $adminGrid->getCollection();
            $this->getLayout()->render();
        } 
        catch (Exception $e) {
            
        }
    }

    public function addAction(){
        Ccc::getModel('Core_Session')->start();

        $adminAdd = new Block_Admin_Edit();
        $this->getLayout()->getChild('content')->addChild('add', $adminAdd);
        $adminAdd->getCollection();
        $this->getLayout()->render();
    }

    public function editAction(){
        Ccc::getModel('Core_Session')->start();
        $id = $this->getRequest()->getParam('id');

        try {
            if(!$id){
                throw new Exception("id not found",1);
            }

            $adminEdit = new Block_Admin_Edit();
            $this->getLayout()->getChild('content')->addChild('edit', $adminEdit);
            $adminEdit->getCollection();
            $this->getLayout()->render();
        }
        catch(Exception $e){
            CcC::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }

    }

    public function saveAction(){
        Ccc::getModel('Core_Session')->start();
        $id = $this->getRequest()->getParam('id');

        if(!$id){
            $addAdmin = $this->getRequest()->getPost('admin');

            try {
                if(!$addAdmin){
                    throw new Exception("admin data not found",1);
                }
                else {
                    $row = Ccc::getModel('Admin_Row')->setData($addAdmin);
                    date_default_timezone_set("Asia/Kolkata");
                    $datetime = date("Y:m:d h:i:sA");
                    $row->created_at = $datetime;
                    $row->save();

                    $this->getMessage()->addMessages("admin row inserted succesffully", Model_Core_Message::SUCCESS);
                }
            } 
            catch (Exception $e) {
                $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
            }
            
        }

        else {
            $updateAdmin = $this->getRequest()->getPost('admin');

            try {
                if(!$updateAdmin){
                    throw new Exception("admin data not found",1);
                }
                else{
                    $row = Ccc::getModel('Admin_Row')->setData($updateAdmin);
                    date_default_timezone_set("Asia/Kolkata");
                    $datetime = date("Y:m:d h:i:sA");
                    $row->updated_at = $datetime;
                    $row->admin_id = $id;
                    $row->save();

                    $this->getMessage()->addMessages("data updated successfully", Model_Core_Message::SUCCESS);
                }
            } 
            catch (Exception $e) {
                $this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
            }
            
        }

        $this->redirect('admin', 'grid',[],true);

    }

    
    public function deleteAction(){
        Ccc::getModel('Core_Session')->start();
        $deleteId = $this->getRequest()->getParam('id');

        try {
            if(!$deleteId){
                throw new Exception("delete id not found : data not deleted",1);
            }
            else{
                Ccc::getModel('Admin_Row')->load($deleteId)->delete();
                $this->getMessage()->addMessages("data deleted successfully", Model_Core_Message::SUCCESS);
            }

        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        
        $this->redirect('admin', 'grid', [], true);
    }
}