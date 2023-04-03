<?php 

class Model_Payment_Row extends Model_Core_Table_Row{
    function __construct(){
        parent::__construct();
        $this->setTableClass('Model_Payment');
    }
}

?>