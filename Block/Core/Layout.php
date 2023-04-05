<?php

class Block_Core_Layout extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();
        $this->setTemplate('core/layout/3columns.phtml');
        $this->prepareChildren();
	}

    public function prepareChildren() {
        $header = new Block_Html_Header();
        $this->addChild('header', $header);

        $footer = new Block_Html_Footer();
        $this->addChild('footer', $footer);

        $message = new Block_Html_Message();
        $this->addChild('message',$message);
    }
}

?>