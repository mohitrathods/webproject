<?php
require_once 'Model/Core/Session.php';


class Model_Core_Message{
    protected $session = null;

    const SUCCESS = 'Success';
    const FAILURE = 'Failure';
    const NOTICE = 'Notice';

    //------------------- setter getter session
    public function setSession($session){
        $this->session = $session;
        return $this;
    }

    public function getSession(){
        if($this->session){
            return $this->session;
        }

        $session = new Model_Core_Session();
        $this->setSession($session);
        return $session;
    }

    public function __construct(){
        $this->getSession();
    }



    //----------------------------
    public function addMessages($message, $type=null){

        if (!$type) {
			$type = self::SUCCESS;
		}

        if($this->getSession()->has('message')){
            $this->getSession()->set('message',[]);
        }

        $messages = $this->getMessages();
        $messages[$type] = $message;

        $this->getSession()->set('message', $messages);
		return $this;

        // $messages = $this->getMessage();
        // $this->getSession()->set('message',$messages);
        // print_r($message);

        
        
        // // $this->getSession()->set($message);
        // return $this;
    }

    public function clearMessage(){
        // $_SESSION['message'] = [];
        // $this->getSession()->unset('message');
        //or
        $this->getSession()->set('message',[]);
        return $this;
    }


    public function getMessages(){
        if (!$this->getSession()->has('message')) {
			return null;
		}
		
        return $this->getSession()->get('message');
    }
}
?>