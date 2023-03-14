<?php

require_once 'Model/Core/Request.php';

class Contoller_Core_Front{
    
    public function init(){
        $request = new Model_Core_Request();
        $controllerName = $request->getControllerName();
        print_r($controllerName); // product
        echo "<br>";

        $controllerClassName = 'Controller_'.ucwords($controllerName,'_'); //Controller_ Product_ 
        print_r($controllerClassName);
        echo "<br>";

        $controllerPathName = 'Controller/'.ucfirst($controllerName).'.php'; //Controller/Product.php

        require_once $controllerPathName; //Controller.Product.php
        
        //$result = new Controller_Product
        $resultClassName = new $controllerClassName();
        
        // $resultClassName->$request->getActionName().'Action';
        $actionPath = $request->getActionName().'Action'; // grid.Action > gridAction
        
        $resultClassName->$actionPath();

    }
}
?>