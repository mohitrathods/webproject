<?php
require_once 'Core/Table.php';

class Model_Attribute extends Model_Core_Table{
    // protected $tableName = 'product';

    // protected $primaryKey = 'product_id';


    function __construct()
	{
		parent::__construct();
		
		$this->setTableName('attribute')->setPrimaryKey('attribute_id');
	}
}
?>