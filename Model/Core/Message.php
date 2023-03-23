<?php
require_once 'Model/Core/Session.php';


class Model_Core_Message{



    protected $session = null;


    public function __construct(){
        $this->getSession();
    }


    public function setSession(Model_Core_Session $session){
        $this->session = $session;
        return $this;
    }

    public function getSession(){
        if($this->session){
            return $this->session;
        }
        $session = new Model_Core_Session();
        $this->session = $session;
        return $session;
    }


    //------------
    public function addMessage($message, $type='success'){

        $session = $this->getSession();

        if($this->getSession()->has('message')){
            $this->getSession()->set('message',[]);
            // return null;
        }

        //check message's key or not
        // if(!array_key_exists('message', $_SESSION)){
        //     $_SESSION['message'] = [];
        //     return null;
        // }
        // $_SESSION = [];

        // $_SESSION['message'][$type] = $message;
        // print_r($_SESSION);

        $messages = $this->getMessage();
        $this->getSession()->set('message',$messages);
        print_r($message);
        
        // $this->getSession()->set($message);
        return $this;


    }

    public function clearMessage(){
        // $_SESSION['message'] = [];
        $this->getSession()->unset('message');
        //or
        // $this->getSession()->set('message',[]);
        return $this;
    }


    public function getMessage(){

        if(!array_key_exists('message',$_SESSION)){
            return null;
        }

        return $_SESSION['message'];
    }
}
?>