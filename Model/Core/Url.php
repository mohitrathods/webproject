<?php
require_once 'Model/Core/Request.php';
class Model_Core_Url{
    
    // public $controller = null;
    // public $action = null;

    //----------- set, get controller name
    // public function setController($controller){
    //     $this->controller = $controller;
    //     return $this;
    // }

    // public function getController(){
    //     // echo "inseide get Controller";
    //     return $this->controller;
        
    // }
    

    //----------- set, get action name
    
    // public function setAction(){}
    // public function getAction(){}

    


    public function getCurrentUrl(){
        echo "<pre>";
        // print_r($_SERVER);
        echo "<br>";
        print_r($_SERVER['REQUEST_SCHEME']);
        echo "<br>";
        print_r($_SERVER['QUERY_STRING']);
        echo "<br>";
        print_r($_SERVER['REQUEST_URI']);
        echo "<br>";
        print_r($_SERVER['HTTP_HOST']);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
      
    }  

    

    public function getUrl($controller = null, $action = null, $params = [], $reset = false){
        // print_r($_SERVER);
        $request = new Model_Core_Request();

        // $final = [];
        $final = $request->getParam();

        //--------- controller
        if($controller){
            $final['c'] = $controller;
        }
        else {
            $final['c'] = $request->getControllerName();
        }

        // $queryString = implode(',',$final);
        $queryString = http_build_query($final);

        //---------- action
        if($action){
            $final['a'] = $action;
        }
        else{
            $final['a'] = $request->getActionName();
        }
        $queryString = http_build_query($final);
        // $queryString = http_build_query($final); // cant do this because of stored in array
        
        //--------------------------------------
        //----- getparam mathi get id
        // $id = $request->getParam('id');
        // print_r($request->getParam());     
        if($params){
            array_merge($final,$params);
        }  
        
        // print_r(array_filter($final));

        //--------------------------------------

        $requestUri = trim($_SERVER['REQUEST_URI'],$_SERVER['QUERY_STRING']);
        echo "<br>";
        $url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$requestUri.$queryString;
        echo "<br>";
        // echo $_SERVER['QUERY_STRING'];
        
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

        return $url;
    }

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

    // public function getUrl(){
    //     $this->getParam();
    //     return $this;
    // }


?>