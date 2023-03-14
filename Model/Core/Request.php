<?php
class Model_Core_Request{
    
    
    //----------- getPost > validate posted data
    public function getPost($key = null, $value = null){
        if($key == null){
            return $_POST;
        }
        print_r($_POST);
        if(array_key_exists($key, $_POST)){
            return $_POST[$key]; 
        }

        return $value;
    }

    //----------- getPost > validate links
    public function getParam($key = null, $value = null){
        if($key == null){
            return $_GET;
        }
        print_r($_GET);
        echo "<br>";
        print_r($value);
        echo "<br>";
        if(array_key_exists($key, $_GET)){
            return $_GET[$key];
        }
        
        return $value;
    }

    //----------------- getRequest 
    public function getRequest($key = null, $value = null){
        if($key == null){
            return $_POST;
        }
        if(array_key_exists($key, $_POST)){
            return $_POST[$key];
        }
    }


    //---------------- GET ACTION AND CONTROLLER NAMES
    public function getActionName(){
        return $this->getParam('a','index');
    }

    public function getControllerName(){
        return $this->getParam('c','index');
    }

}
?>