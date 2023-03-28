<?php


class Model_Core_Table_Row{
    protected $data = [];
	
    protected $tableName = null;
	
    protected $primaryKey = null;
	
    protected $table = null;
	
    protected $tableClass = null;


    //--------------------- set get  table 
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
    public function setTableName($tablename){
        $this->tableName = $tablename;
        return $this;
    }

    public function getTableName(){
        return $this->tableName;
    }

    //----------------------- set get primary key
    public function setPrimaryKey($primarykey){
        $this->primaryKey = $primarykey;
        return $this;
    }

    public function getPrimaryKey(){
        return $this->primaryKey;
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
			return $this->data[$key];
		}

        return null;
    }

    /*------------------------------------------------------*/
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


    public function load($id, $column = null){
        if($column == null){
            $column = $this->getPrimaryKey();
        }

        $tableName = $this->getTableName();
        $query = "SELECT * FROM `{$tableName}` WHERE `{$column}` = `{$id}`";
        $result = $this->getTable()->fetchRow($query);

        if($result){
            $this->data = $result;
        }
        return $this;

    }

    public function save(){
        //check if array key exists in data = []
        if(!array_key_exists($this->primaryKey, $this->data)){
            $id = $this->getTable()->insert($this->data);
        
            if($id){
                $this->load($id);
                return true;
            }   

            return false;
        }

        else {
            $id = $this->getData($this->getPrimaryKey());
            $condition[$this->getPrimaryKey()] = $id;

            $result = $this->getTable()->update($this->data, $condition);
            if($result){
                $this->load($id);
                return true;
            }

            return false;
        }

    }

    public function fetchAll($query){
        $result = $this->getTable()->fetchAll($query);
        if($result){
            $this->data = $result;
        }

        return $this;
    }

    public function fetchRow($query){
        $result = $this->getTable()->fetchRow($query);
        if($result){
            $this->data = $result;
        }

        return $this;
    }

    public function delete(){
        $id = $this->getData($this->primaryKey);
		$condition[$this->primaryKey] = $id;

        $result = $this->getTable()->delete($condition);
        if($result){
            return true;
        }

        return false;
    }

}

?>