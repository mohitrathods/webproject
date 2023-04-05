<?php


class Block_Payment_Grid extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();


        $this->setTemplate('payment/grid.phtml');
	}

    public function getCollection(){
        //set data here and call collection in construct above
        $query = "SELECT * FROM `payment`";
        $payments = Ccc::getModel('Payment_Row')->fetchAll($query);
        $this->setData(['payments' => $payments]);
    }
    

    

  
}

?>