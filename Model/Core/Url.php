<?php
class Model_Core_Url extends Model_Core_Request{
    
    public $controller = null;
    public $action = null;

    public function getCurrentUrl(){
        echo "<pre>";
        print_r($_SERVER);
        echo "<br>";
        print_r($_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        echo "<br>";
      
    }  


    //geturl method
    //if current url get it 
    //if > currenturl = grid > c is availabe > only pass action
    //this->getUrl('add', 'controller', [id=5, 'tab'=>'address information'])
    //$this->getURL ( controller, action, params = ['id'=>5,.....])

    //get host, request url

    //get query string
    //either todo query string or
    //another method > query_string to array OR array to query string
    //use getparam 
    //build array for parameter 

    public function getUrl(){
        $this->getParam();
        return $this;
    }

}

?>