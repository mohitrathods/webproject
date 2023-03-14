<?php
class Model_Core_Table{
    
    //table name > example product, primary key of table, model
    protected $tableName = null;
    protected $primaryKey = null;

    protected $adapter = null;

    //------------------- set & get tablename

    //as parameter, from product controller getModel() access, and Table extended in Product_Model
    //so all functions of Table are accessiblr to product > passing value product 
    //from Product controller through product model and setting it in setTableName as parameter
    public function setTableName($parameter){
        $this->tableName = $parameter;
        return $this;
    }

    public function getTableName(){
        return $this->tableName;
    }

    //------------------- set & get primarykey

    public function setPrimaryKey($parameter){
        $this->primaryKey = $parameter;
        return $this;
    }

    public function getPrimaryKey(){
        return $this->primaryKey;
    }


    //------------------- set & get adapter

    // public function setAdapter($parameter){
    //     $this->adapter = $parameter;
    //     return $this;
    // }

    public function getAdapter(){
        //access to adapter class
        if($this->adapter){
            return $this->adapter;
        }
        $adapter = new Adapter();
        $this->adapter = $adapter;
        return $adapter; //means $adapter->fetchAll($query);

    }

    

    //------------------------------------------------------------

    public function fetchAll(){
        $tableName = $this->getTableName(); //or only tableName, because "product" is setted into tableName var

        $query = "SELECT * FROM `$tableName` WHERE 1";
        return $this->getAdapter()->fetchAll($query); //return this result
        
    }
    
}
?>