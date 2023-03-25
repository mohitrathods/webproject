<?php
class Model_Core_Table_Row{
    protected $data = [];

    protected $tableName = 'product';
    protected $primaryKey = '';


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

    public function load($id, $column = 'product_id'){
        if(!$column){
            //$column = $this->getPrimaryKey();            
        }
        $query = "SELECT * FROM `product` WHERE `{$column}` = {$id}";
        $table = new Model_Core_Table();
        // $productRow = $table->fetchRow($query);
        $productRow = $table->fetchRow($query);
        if($productRow){
            $this->data = $productRow;
        }
        return $this;
    }

    //fetchrow, all, load, update, delete
    // aa class ma table name and primary key variable
    public function fetchRow($query){
        // $result = $this->getTable()->fetchRow($query);

        $table = new Model_Core_Table();
        $result = $table->fetchRow($query);
        if($query){
            $this->data = $query;
        }
        return $this;
    }

    public function fetchAll($query){
        $table = new Model_Core_Table();
        $result = $table->fetchRow($query);
        if($query){
            $this->data = $query;
        }
        return $this;
    }
}

?>