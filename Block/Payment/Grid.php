<?php


class Block_Payment_Grid extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();
        $query = "SELECT * FROM `payment`";
        $payments = Ccc::getModel('Payment_Row')->fetchAll($query);
        
        Ccc::getModel('Core_Message')->getSession()->start();
        
        try {
            if(!$payments){
                throw new Exception("data not found",1);
            }
            
            $this->setTemplate('payment/grid.phtml')->setData(['payments' => $payments]);
        } 
        catch (Exception $e) {
            Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
        }
	}

    

    

  
}

?>