<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }     
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {        
        $layout = $this->_helper->layout();
        $layout->setLayout('layout_login');

        $form = new Application_Model_FormLogin();

        // echo "sidiar: " . md5("sidiar");
        
            // Has the login form been posted?
         if ($this->getRequest()->isPost()) {

           // If the submitted data is valid, attempt to authenticate the user
           if ($form->isValid($this->_request->getPost())) {

             // Did the user successfully login?
             if ($this->_authenticate($this->_request->getPost())) {

                 /* Doctrine
               $account = $this->em->getRepository('Entities\Account')
                               ->findOneByEmail($form->getValue('email'));

               // Save the account to the database
               $this->em->persist($account);
               $this->em->flush();
               */
                 
               // Generate the flash message and redirect the user
               $this->_helper->flashMessenger->addMessage(
                 Zend_Registry::get('config')->messages->login->successful
               );

               return $this->_helper->redirector('index', 'index');

             } else {
               $this->view->errors = array( "form" => array(
                 Zend_Registry::get('config')->messages->login->failed
               ));
             }

           } else {               
             $this->view->errors = $form->getErrors();
           }

         }


        $this->view->form = $form;
        
    }
    
    
    
  protected function _authenticate($data)
  {


    $db = Zend_Db_Table::getDefaultAdapter();
    $authAdapter = new Zend_Auth_Adapter_DbTable($db);

    $authAdapter->setTableName('users');
    $authAdapter->setIdentityColumn('email');
    $authAdapter->setCredentialColumn('password');
    $authAdapter->setCredentialTreatment('MD5(?) and status = 1');

    $authAdapter->setIdentity($data['email']);
    $authAdapter->setCredential($data['pswd']);

    $auth = Zend_Auth::getInstance();
    $result = $auth->authenticate($authAdapter);

    if ($result->isValid())
    {

      if ($data['public'] == "1") {

        Zend_Session::rememberMe(1209600);

      } else {

        Zend_Session::forgetMe();	

      }

      return TRUE;

    } else {

      return FALSE;

    }


  }

  
  public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->flashMessenger->addMessage('You are logged out of your account');
        $this->_helper->redirector('index', 'index');
    }

}

