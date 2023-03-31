<?php
require_once 'Controller/Core/Action.php';

class Controller_Admin extends Contoller_Core_Action{
    public function gridAction(){
        $this->getMessage()->getSession()->start();
        $query = "SELECT * FROM `admin` ORDER BY `admin_id` ASC";
        $admins = Ccc::getModel('Admin_Row')->fetchAll($query);
        
        try {
            if(!$admins){
                throw new Exception("admin data not found" ,1);
            }

            $this->getView()->setTemplate('admin/grid.phtml')->setData(['admins' => $admins])->render();
        } 
        catch (Exception $e) {
            $this->getMessage()->addMessages($e->getMessage() , Model_Core_Message::FAILURE);
        }

        $this->redirect('admin', 'grid');
    }

    public function addAction(){
        $adminRow = Ccc::getModel('Admin_Row');
        $this->getView()->setTemplate('admin/edit.phtml')->setData(['admins' => $adminRow])->render();
    }

    public function editAction(){
        $id = $this->getRequest()->getParam('id');
        $adminRow = Ccc::getModel('Admin_Row')->load($id);

        $this->getView()->setTemplate('admin/edit.phtml')->setData(['admins' => $adminRow])->render();
    }

    public function saveAction(){
        $this->getMessage()->getSession()->start();
        $id = $this->getRequest()->getParam('id');

        // try {
        //     if(!$id){
        //         throw new Exception("id not found")
        //     }
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }

        if(!$id){
            $addAdmin = $this->getRequest()->getPost('admin');
            $row = Ccc::getModel('Admin_Row')->setData($addAdmin);
            date_default_timezone_set("Asia/Kolkata");
            $datetime = date("Y:m:d h:i:sA");
            $row->created_at = $datetime;
            $result = $row->save();
        }

        else {
            echo "<pre>";
            print_r("update");
            $updateAdmin = $this->getRequest()->getPost('admin');
            $row = Ccc::getModel('Admin_Row')->setData($updateAdmin);
            date_default_timezone_set("Asia/Kolkata");
            $datetime = date("Y:m:d h:i:sA");
            $row->updated_at = $datetime;
            $row->admin_id = $id;
            $result = $row->save();
        }

        $this->redirect('admin', 'grid',[],true);

    }

    
    public function deleteAction(){
        $this->getMessage()->getSession()->start();
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