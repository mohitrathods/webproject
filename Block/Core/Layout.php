<?php

class Block_Core_Layout extends Block_Core_Abstracts {
    public function __construct(){ //call parent in all class
        parent::__construct();
        $this->setTemplate('core/layout/3columns.phtml');
        // $this->setTemplate('core/layout/2columns.phtml');
        $this->prepareChildren();
	}

    

    public function prepareChildren() {

        $content = new Block_Html_Content();
        $this->addChild('content', $content);

        $header = new Block_Html_Header();
        $this->addChild('header', $header);

        $footer = new Block_Html_Footer();
        $this->addChild('footer', $footer);

        $message = new Block_Html_Message();
        $this->addChild('message',$message);

        $left = new Block_Html_Left();
        $this->addChild('left',$left);

        $right = new Block_Html_Right();
        $this->addChild('right',$right);
    }

    public function createBlock($blockname){
        // $head = new Block_Html_Head(); //make above dynamic 
        $class = 'Block_Html_'.$blockname;
        $result = new $class;
        $this->addChild('block',$result);//render block by calling function in content
        return $result;
    }
}

?>