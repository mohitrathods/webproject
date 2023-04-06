<?php

class Block_Admin_Edit extends Block_Core_Abstracts {
    public function __construct(){
        parent::__construct();
    }

    public function getCollection() {
        $id = Ccc::getModel('Core_Request')->getParam('id');

        if(!$id){
            $adminRow = Ccc::getModel('Admin_Row');
            $this->setTemplate('admin/edit.phtml')->setData(['admins' => $adminRow]);
        }

        else {
            $adminRow = Ccc::getModel('Admin_Row')->load($id);
            $this->setTemplate('admin/edit.phtml')->setData(['admins' => $adminRow]);
        }
    }
}

?>