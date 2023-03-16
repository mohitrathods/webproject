<?php
require_once "Core/Table.php";

class Model_Shipping extends Model_Core_Table{

    protected $tableName = 'shipping';

    protected $primaryKey = 'shipping_method_id';
}

?>