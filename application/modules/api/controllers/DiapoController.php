<?php
require_once APPLICATION_PATH . '/../library/AMC/Magazine/AMCFactory.php';

require_once APPLICATION_PATH . '/../library/AMC/ContentMapper/ContentMapper.php';

class Api_DiapoController extends Zend_Rest_Controller
{
    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function headAction() {
        $this->getResponse()->setBody(null);
    }
    
    public function optionsAction(){
        $this->getResponse()->setBody(null);
        $this->getResponse()->setHeader('Allow', 'OPTIONS, HEAD, INDEX, GET, POST, PUT, DELETE');
    }  
    
    public function indexAction()
    {
      
        
        
       // $this->putAction();
      /*
        $amcFactory = AMC\AMCFactory::getInstance();
        $diapo = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_DIAPO);
        $diapoMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_DIAPO);
        
        $diapo->id = '1';
        $diapo->status = '2';
        
        $diapo->publish_date_from = '2014-11-30';
        
        try{
         $diapoMapper->update($diapo);
        } catch  (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }*/
        
         $this->getResponse()
            ->appendBody();
    }
    
    public function getAction()
    {
        $this->getResponse()
            ->appendBody("From getAction() returning the requested diapo")
                ->setHttpResponseCode(200);
    }
    
    public function postAction()
    {
        $postParams = Zend_Json::decode($this->getRequest()->getParam('model'));
         
        $amcFactory = AMC\AMCFactory::getInstance();
        $diapo = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_DIAPO);
        $diapoMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_DIAPO);

        $diapo->title = $postParams['title'];
        $diapo->section_id = $postParams['section_id'];

        $diapo_id = $diapoMapper->add($diapo);
        
//        echo  Zend_Json::encode(array('id'=>$diapo_id));
//                ->appendBody("{'id': '$diapo_id' }")
        
        $this->getResponse()
                ->appendBody(Zend_Json::encode(array('id'=>$diapo_id)))
                ->setHttpResponseCode(200);
    }
    


    public function putAction()
    {
        
        
        
        if ($this->_request->isPut()) {
            $putParams = Zend_Json::decode($this->getRequest()->getParam('model'));
            
         //   parse_str($this->_request->getRawBody(), $putParams);
//            $request->setParams($putParams);
           // $el_id = $putParams['id'];
        }
        

        
        $amcFactory = AMC\AMCFactory::getInstance();
        $diapo = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_DIAPO);
        $diapoMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_DIAPO);
        
        
        
        /* update article */
        $diapo->id = $putParams['id'];

        if (isset($putParams['title'])) {
            $diapo->title = $putParams['title'];
        }
        if (isset($putParams['text'])) {
            $diapo->text = $putParams['text'];
        }
                
        
        $diapoMapper->update($diapo);
        
        $this->getResponse()
                ->setHttpResponseCode(200);
        
    }
    
    public function deleteAction()
    {
        $diapoMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_DIAPO);
        
        if ($diapoMapper->delete($this->_request->getParam('id'))==1) {
            $this->getResponse()
                ->setHttpResponseCode(200);
        }else {
             $this->getResponse()
                ->setHttpResponseCode(500);
        }
                
    }
}

?>