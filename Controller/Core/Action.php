<?php

require_once 'Model/Core/Adapter.php';
require_once 'Model/Core/Request.php';


class Contoller_Core_Action{
    
    protected $request = null;
    protected $adapter = null;

    //----------- set get of request

    public function setRequest($request){
        $this->request = $request;
        return $this;
    }

    public function getRequest(){
        if($this->request){
            return $this->request;
        }

        $request = new Model_Core_Request();
        $this->request = $request;
        return $request;
    }

    //----------- set get of adapter

    public function getAdapter(){
        if($this->adapter){
            return $this->adapter;
        }
        $adapter = new Adapter();
        $this->adapter = $adapter;
        return $adapter;
    }


    //redirect dynamic
    public function redirect($url){
        header("location:{$url}");
        exit();
    }

    //require once > getTemplate or get Page
    public function getTemplate($templatePath){
        require_once 'View'.DS.$templatePath;
    }

    

}
?>