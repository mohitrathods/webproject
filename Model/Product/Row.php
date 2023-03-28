<?php

require_once 'Model/Product.php';

class Model_Product_Row extends Model_Core_Table_Row{
    protected $tableName = 'product';

    protected $primaryKey = 'product_id';

    protected $tableClass = 'Model_Product';

    const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const STATUS_ACTIVE_LBL = 'active';
	const STATUS_INACTIVE_LBL = 'inactive';
	const STATUS_DEFAULT = 2;

    //method getstatus optinos
}

?>