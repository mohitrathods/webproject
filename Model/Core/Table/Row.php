<?php

require_once 'Model/Core/Table.php';
class Model_Core_Table_Row {
    protected $data = [];
	
    protected $table = null;
    protected $tableClass = null;

    function __construct(){

    }
	


    //--------------------- set get  table 

    public function setTableClass($tableClass)
    {
		$this->tableClass = $tableClass;
		return $this;
	}
    public function setTable($table){
        $this->table = $table;
        return $this;
    }

    public function getTable(){
        if($this->table){
            return $this->table;
        }

        $table = new ($this->tableClass)();
        $this->setTable($table);
        return $table;
    }


    //------------------- set get tablename

    public function getTableName(){
        return $this->getTable()->getTableName();
    }

    //----------------------- set get primary key

    public function getPrimaryKey(){
        return $this->getTable()->getPrimaryKey();
        
    }


    //---------------------- set get data
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function getData($key = null){
        if ($key == null) {
			return $this->data;
		}

        if (array_key_exists($key, $this->data)) {
			return $this->data[$key]; //returns value
		}

        return null;
    }


    /*------------------------magic methods------------------------------*/
    public function __set($key, $value) 
	{
		$this->data[$key] = $value;
	}
    
    public function __get($key)
	{
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}
		return null;
	}

	public function __unset($key)
	{
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}

    /*------------------- add data remove data ---------------------- */
    public function addData($key, $value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function removeData($key = null)
	{
		if ($key == null) {
			$this->data = [];
		}

		if (!array_key_exists($key, $this->data)) {
			unset($this->data);
		}
		return $this;
	}

    /*--------------------------- load and save methods ------------------------ */

    public function load($id, $column = null){
        // if($column == null){
        //     $column = $this->getPrimaryKey();
        // }

        // $tableName = $this->getTableName();
        // $query = "SELECT * FROM `{$tableName}` WHERE `{$column}` = {$id}";
        // $result = $this->getTable()->fetchRow($query);
        // // print_r($id);

        // if($result){
        //     $this->data = $result;
        // }
        // return $this;

        if (!$column) {
			$column = $this->getPrimaryKey();
		}
		$query = "SELECT * FROM `{$this->getTableName()}` WHERE `{$column}` = {$id}";

		$result = $this->getTable()->fetchRow($query);
		if ($result) {
			$this->data = $result;
		}
		return $this;

    }

    public function save(){
        //check if array key exists in data = []
        if(!array_key_exists($this->getPrimaryKey(), $this->data)){//no primary key = producu_id whille insert
            $id = $this->getTable()->insert($this->data);
            
            if($id){
                $this->load($id);
                return $this;
            }   

            return false;
        }

        else {
            $id = $this->getData($this->getPrimaryKey());
            // print_r($id);
            $condition[$this->getPrimaryKey()] = $id;
            // unset($this->data[$this->getPrimaryKey()]);
            


            $result = $this->getTable()->update($this->data, $condition);
            if($result){
                $this->load($id);
                return true;
            }

            return false;
        }

    }

    /* ---------------------- all functions --------------------------- */

    public function fetchAll($query){
        $result = $this->getTable()->fetchAll($query);
        if(!$result){
            return false;
        }
        foreach($result as &$row){
			$row = (new $this)->setData($row)->setTable($this->getTable());
		}

        return $result;
    }

    public function fetchRow($query){
        $result = $this->getTable()->fetchRow($query);
        if($result){
            $this->data = $result;
            return $this;
        }
        return false;
    }


    public function delete(){
        $id = $this->getData($this->getPrimaryKey()); //no direct use $this->getPrimarykey();
		// $condition[$this->primaryKey] = $id;
        // print_r($id);
        // if(!$id){
        //     echo "null";
        // }

        $result = $this->getTable()->delete($id);
        
        if($result){
            return true;
        }

        return false;
    }

}

?>