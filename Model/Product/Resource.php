<?php

class Model_Product_Resource extends Model_Core_Table_Resource{
    function __construct()
    {
        parent::__construct();
        
        $this->setResourceName('product')->setPrimaryKey('product_id');
    }
}
?>