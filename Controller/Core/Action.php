<?php

require_once 'Model/Core/Adapter.php';
require_once 'Model/Core/Request.php';


class Contoller_Core_Action{
    
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