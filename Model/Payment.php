<?php

require_once 'Core/Table.php';

class Model_Payment extends Model_Core_Table{
    protected $tableName = 'payment';

    protected $primaryKey = 'payment_method_id';
}
?>