<?php
require_once 'Core/Table.php';

class Model_Product extends Model_Core_Table_Resource{
    // protected $tableName = 'product';

    // protected $primaryKey = 'product_id';


    function __construct()
	{
		parent::__construct();
		
		$this->setResourceName('product')->setPrimaryKey('product_id');
	}
}
?>