<?php

class Model_Customer_Resource extends Model_Core_Table_Resource{
    function __construct()
    {
        parent::__construct();
        
        $this->setResourceName('customer')->setPrimaryKey('customer_id');
    }
}
?>