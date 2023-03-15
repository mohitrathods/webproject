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
        $model = new Model_Core_Table;
        $this->model = $model;
        return $model;
    }

    public function gridAction(){
         $query = "SELECT * FROM `salesman` WHERE 1";
        $salesman = $this->getModel()->fetchAll($query);
        
        $this->setSalesMan($salesman);

        $this->getTemplate("salesman/grid.phtml");
    }

}
?>