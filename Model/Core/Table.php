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
    public function setTableName($tablename){
        $this->tableName = $tablename;
        return $this;
    }

    public function getTableName(){
        return $this->tableName;
    }

    //------------------- set & get adapter

    public function setAdapter($parameter){
        $this->adapter = $parameter;
        return $this;
    }

    public function getAdapter(){
        //access to adapter class
        if($this->adapter){
            return $this->adapter;
        }
        $adapter = new Adapter();
        $this->setAdapter($adapter);
        return $adapter; 

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

        $query = "INSERT INTO `{$this->getTableName()}` ({$keyString}) VALUES ({$valueString})";
        
        return $this->getAdapter()->insert($query);

    }

    public function fetchRow($query){
        return $this->getAdapter()->fetchRow($query);
    }

    public function update($data,$condition){

        foreach ($data as $key => $value) {
            $keys[] = "`$key` = '$value'";
        }
        
        $testString = implode(',',$keys);

        foreach($condition as $key => $value){
            $conditionString[] = "`$key` = '$value'";
        }

        $implode = implode('AND',$conditionString);

        $query = "UPDATE `{$this->tableName}` SET $testString WHERE $implode";

        return $this->getAdapter()->update($query);
    }
    
    public function delete($deleteId){
        $query = "DELETE FROM `{$this->tableName}` WHERE `{$this->primaryKey}` = '{$deleteId}'";
        return $this->getAdapter()->delete($query);
    }

    public function load($value, $column = null)
	{
		$column = (!$column) ? $this->getPrimaryKey() : $column;
		$query = "SELECT * FROM `{$this->tableName}` WHERE `{$column}` = $value";
		$row = $this->getAdapter()->fetchRow($query);
		return $row;	
	}
}
?>