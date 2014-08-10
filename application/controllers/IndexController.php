<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
       if(!Zend_Auth::getInstance()->hasIdentity())  
        {  
            $this->_redirect('account/login/index');  
        }  
    }

    public function indexAction()
    {
        // action body
    }


}

