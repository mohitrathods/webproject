<?php

class Model_Vendor_Address extends Model_Core_Table{
    function __construct(){
        parent::__construct();
        $this->setResourceClass('Model_Vendor_Address_Resource');
        $this->setCollectionClass('Model_Vendor_Address_Collection');
    }
}

?>