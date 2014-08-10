<?php

require_once APPLICATION_PATH . '/../library/SIDIAR/Controller/Action/Helper/Initializer.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    
  protected function _initConfig()
  {
    $config = new Zend_Config($this->getOptions());
    Zend_Registry::set('config', $config);
    
    $front = Zend_Controller_Front::getInstance();
    $router = $front->getRouter();
        
    $restRoute = new Zend_Rest_Route($front, array(), array(
            'api',
        ));
    $router->addRoute('rest', $restRoute);
    
    $front->registerPlugin(new Zend_Controller_Plugin_PutHandler());
         
  }
  
  protected function _initGlobalVars() {
      
      Zend_Controller_Action_HelperBroker::addPath(
                APPLICATION_PATH . '/../library/SIDIAR/Controller/Action/Helper'
        );
        $initializer = Zend_Controller_Action_HelperBroker::addHelper(
                        new SIDIAR_Controller_Action_Helper_Initializer()
        );
        
    }
    
}
