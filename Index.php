<?php
define('DS',DIRECTORY_SEPARATOR);
require_once 'Controller/Core/Front.php';


class Index {
    public static function init(){
        $front = new Contoller_Core_Front();
        $front->init();
    }
}
Index::init();
?>