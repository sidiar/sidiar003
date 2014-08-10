<?php
require_once APPLICATION_PATH . '/../library/AMC/Magazine/AMCFactory.php';

require_once APPLICATION_PATH . '/../library/AMC/ContentMapper/ContentMapper.php';

class Api_StatusController extends Zend_Rest_Controller
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
      /*
        $amcFactory = AMC\AMCFactory::getInstance();
        $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        $articleMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_ARTICLE);
        
        $article->id = '1';
        $article->status = '2';
        
        $article->publish_date_from = '2014-11-30';
        
        try{
         $articleMapper->update($article);
        } catch  (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }*/
        
         $this->getResponse()
            ->appendBody("");
    }
    
    public function getAction()
    {
        $this->getResponse()
            ->appendBody("From getAction() returning the requested article")
                ->setHttpResponseCode(200);
    }
    
    public function postAction()
    {
        $this->getResponse()
            ->appendBody("From postAction() creating the requested article")
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
        
        /*
         * Utilizo articleMapper como una clase genérica para modificar el status 
         * de cualquier tipo de contenido. Faltaría poder manipular contenidos 
         * sin sus clases concretas, de manera genérica.
         */
        
        $amcFactory = AMC\AMCFactory::getInstance();
        $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        $articleMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_ARTICLE);
        
        
        
        /* update article */
        $article->id = $putParams['id'];
        $article->status = $putParams['status'];
        
        $article->publish_date_from = $putParams['publish_date_from'];
        $article->publish_date_to = $putParams['publish_date_to'];
        if (!empty($putParams['expires'])) {
            $article->expires = $putParams['expires'];
        }else{
            $article->expires = '0';
        }
        
        $articleMapper->update($article);
        
        $this->getResponse()
                ->appendBody("status: " . $putParams['status'])
                ->setHttpResponseCode(200);
        
    }
    
    public function deleteAction()
    {
        $this->getResponse()
            ->appendBody("From deleteAction() deleting the requested article");
    }
}

?>