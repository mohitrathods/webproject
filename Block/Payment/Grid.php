<?php


class Block_Payment_Grid extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();
        $query = "SELECT * FROM `payment`";
        $payments = Ccc::getModel('Payment_Row')->fetchAll($query);
        
        $this->setTemplate('payment/grid.phtml')->setData(['payments' => $payments]);
	}

    

    

  
}

?>