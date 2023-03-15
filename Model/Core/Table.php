<?php

// require_once 'Model/Core/Request.php';
class Model_Core_Table extends Model_Core_Request{
    
    //table name > example product, primary key of table, model
    protected $tableName = null;
    protected $primaryKey = null;

    protected $adapter = null;


    //------------------- set & get primarykey

    public function setPrimaryKey($primaryKey){
        $this->primaryKey = $primaryKey;
        return $this;
    }

    public function getPrimaryKey(){
        return $this->primaryKey;
    }

    


    //------------------- set & get tablename

    //as parameter, from product controller getModel() access, and Table extended in Product_Model
    //so all functions of Table are accessiblr to product > passing value product 
    //from Product controller through product model and setting it in setTableName as parameter
    public function setTableName($tablename){
        $this->tableName = $tablename;
        return $this;
    }

    public function getTableName(){
        return $this->tableName;
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

    public function fetchAll($query){
        
        return $this->getAdapter()->fetchAll($query); //return this result
        
    }

    public function insert($data){
        $keys = array_keys($data);
        $values = array_values($data);
        
        $keyString = "`".implode('`,`',$keys)."`";
        $valueString = "'".implode("','",$values)."'";

        $query = "INSERT INTO `{$this->tableName}` ({$keyString}) VALUES ({$valueString})";
        $this->getAdapter()->insert($query);
    }

    public function fetchRow($query){
        return $this->getAdapter()->fetchRow($query);
    }

    public function update($data){

        foreach ($data as $key => $value) {
            $keys[] = "`$key` = '$value'";
        }

        $testString = implode(',',$keys);

        $query = "UPDATE `{$this->tableName}` SET $testString WHERE `{$this->getPrimaryKey()}` = '{$this->getParam('id')}'";
        $this->getAdapter()->update($query);
    }
    
    public function delete($deleteId){

        $query = "DELETE FROM `{$this->tableName}` WHERE `{$this->primaryKey}` = '{$deleteId}'";
        $this->getAdapter()->delete($query);
    }
}
?>