<?php

class Block_Core_Layout extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();
        $this->setTemplate('core/layout/3columns.phtml');
	}

    public function prepareChildren() {
        $content = new Block_Html_Content();
        $this->addChild('content',$content);
    }
}

?>