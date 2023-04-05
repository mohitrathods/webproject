<?php

class Block_Shipping_Grid extends Block_Core_Abstracts {
    public function __construct(){
        parent::__construct();

        $query = "SELECT * FROM `shipping`";
    }
}

?>