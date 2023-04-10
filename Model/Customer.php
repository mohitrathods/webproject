<?php
class Model_Customer extends Model_Core_Table{

    function __construct(){
        parent::__construct();
        $this->setResourceClass('Model_Customer_Resource');
        $this->setCollectionClass('Model_Customer_Collection');
    }

}
?>