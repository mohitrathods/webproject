<?php


class Block_Admin_Grid extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();

	}

    public function getCollection(){
        $query = "SELECT * FROM `admin`";
        $admins = Ccc::getModel('Admin_Row')->fetchAll($query);
        $this->setTemplate('admin/grid.phtml')->setData(['admins' => $admins]);
    }
    

    

  
}

?>