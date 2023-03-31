<?php

// Report all PHP errors
error_reporting(E_ALL);

define('DS',DIRECTORY_SEPARATOR);
require_once 'Controller/Core/Front.php';

spl_autoload_register(
    function($className){
        $classPath = str_replace("_","/",$className);
        require_once "{$classPath}.php";
    } 
);


class Ccc {
    public static function init(){
        $front = new Contoller_Core_Front();
        $front->init();
    }

    public static function getModel($className){
        $className = 'Model_'.$className;
        // print_r(new $className);
        return new $className();
    }

    
}

Ccc::init();
?>