<?php

require_once 'Controller/Core/Action.php';
require_once 'Model/Salesman.php';

class Controller_Salesman extends Contoller_Core_Action{
    protected $salesman = [];

    protected $salesmanId = null;

    protected $model = null;

    //------------ get salesman and set salesman

    public function setSalesMan($salesman){
        $this->salesman = $salesman;
        return $this;
    }

    public function getSalesMan(){
        return $this->salesman;
    }

    //------------ get model and set model
    // public function setModel($model){
    //     $this->model = $model;
    //     return $this;
    // }

    public function getModel(){
        if($this->model){
            return $this->model;
        }
        $model = new Model_Salesman();
        $this->model = $model;
        return $model;
    }

    public function gridAction(){
         $query = "SELECT * FROM `salesman` WHERE 1";
        $salesman = $this->getModel()->fetchAll($query);
        
        $this->setSalesMan($salesman);

        $this->getTemplate("salesman/grid.phtml");
    }

    public function addAction(){
        $this->getTemplate("salesman/add.phtml");
    }

    public function insertAction(){
        $salesman = $this->getRequest()->getPost('salesman');

        $this->getModel()->insert($salesman);

        $this->redirect("index.php?c=salesman&a=grid");

    }

    public function editAction(){
        $query = "SELECT * FROM `salesman` WHERE `salesman_id` = '{$this->getRequest()->getParam('id')}'";

        $salesmanRow = $this->getModel()->fetchRow($query);

        $this->setSalesMan($salesmanRow);

        $this->getTemplate("salesman/edit.phtml");
    }

    public function updateAction(){
        $salesman = $this->getRequest()->getPost('salesman');
        
        $this->getModel()->update($salesman);

        $this->redirect("index.php?c=salesman&a=grid");
    }

    public function deleteAction (){
        $deleteId = $this->getRequest()->getParam('id');

        $this->getModel()->delete($deleteId);

        $this->redirect("index.php?c=salesman&a=grid");
    }

    

}
?>