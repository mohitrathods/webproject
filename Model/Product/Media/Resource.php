<?php

class Model_Product_Media_Resource extends Model_Core_Table_Resource{
    function __construct()
    {
        parent::__construct();
        
        $this->setResourceName('product_media')->setPrimaryKey('media_id');
    }
    
}
?>