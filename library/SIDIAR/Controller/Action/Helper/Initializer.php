<?php

class Sidiar_Controller_Action_Helper_Initializer extends Zend_Controller_Action_Helper_Abstract {
      
    public function init() {

        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {

            $identity = $auth->getIdentity();

            if (isset($identity)) {

                /*
                 * Doctrine
                $em = $this->getActionController()
                        ->getInvokeArg('bootstrap')
                        ->getResource('entityManager');

                // Retrieve information about the logged-in user
                $account = $em->getRepository('Entities\Account')
                        ->findOneByEmail($identity);
                       */
               // Zend_Layout::getMvcInstance()->getView()->account = $account;
                Zend_Layout::getMvcInstance()->getView()->account = "sidiar";
            }
        }
    }

}
