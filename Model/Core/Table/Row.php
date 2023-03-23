<?php
class Model_Core_Table_Row{
    protected $data = [];

    protected $class = null;

    //--- set data get data
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function getData($key){
        if($key == null){
            return $this->data;
            // return $this->data[$key];
        }

        if(array_key_exists($key, $this->data)){
            return $this->data[$key];
        }
        
        return null;
    }

    public function addData($key,$value){
        // $this->data[$key] = $value;
        return $this->data[$key] = $value;
        // return $this;
    }

    // public function addData($key,$value){
    //     $this->data[$key] = $value;
    //     return $this;
    // }

    public function removeData($key, $value){
        // return $this->data[$key] = []; //check if unset and this is similar
        unset($this->data[$key]);
        return $this;
    }

    public function __set($key, $value){ 
        //name and email aa class ma defined nathi to aa set magic method 
        //bypass kri dese atle class ma variable define nahi krva dye
        //without aa method, variable can be  added
        // echo "$key = $value"; //returns value which are being bypassed
        //jo variable pelethi define che to e outside ma class ma set thase
        $this->data[$key] = $value;
    }

    public function __get($key){
        if(array_key_exists($key, $this->data)){
            return $this->data[$key];
        }
        
        return null;
    }

    public function __unset($key){
         if(array_key_exists($key, $this->data)){
            return $this->data[$key];
        }
        
        return $this;
    }

    public function save(){
        print_r($this->data);
    }

    //fetchrow, all, load, update, delete
    // aa class ma table name and primary key variable
}

?>