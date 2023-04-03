<?php

require_once 'Core/Table.php';

class Model_Payment extends Model_Core_Table{
    function __construct()
	{
		parent::__construct();
		
		$this->setTableName('payment')->setPrimaryKey('payment_method_id');
	}
}
?>