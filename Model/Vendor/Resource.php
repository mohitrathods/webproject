<?php

class Model_Vendor_Resource extends Model_Core_Table_Resource{
    function __construct()
    {
        parent::__construct();
        
        $this->setResourceName('vendor')->setPrimaryKey('vendor_id');
    }
}
?>