<?php
require_once APPLICATION_PATH . '/../library/AMC/Magazine/AMCFactory.php';

require_once APPLICATION_PATH . '/../library/AMC/ContentMapper/ContentMapper.php';

class Api_ContentController extends Zend_Rest_Controller
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
        $postParams = Zend_Json::decode($this->getRequest()->getParam('model'));
         
        $amcFactory = AMC\AMCFactory::getInstance();
        $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        $articleMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_ARTICLE);

        $article->title = $postParams['title'];
        $article->section_id = $postParams['section_id'];

        $article_id = $articleMapper->add($article);
        
//        echo  Zend_Json::encode(array('id'=>$article_id));
//                ->appendBody("{'id': '$article_id' }")
        
        $this->getResponse()
                ->appendBody(Zend_Json::encode(array('id'=>$article_id)))
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
        $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        $articleMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_ARTICLE);
        
        
        
        /* update article */
        $article->id = $putParams['id'];

        if (isset($putParams['title'])) {
            $article->title = $putParams['title'];
        }
        if (isset($putParams['text'])) {
            $article->text = $putParams['text'];
        }
        if (isset($putParams['section_id'])) {
            $article->section_id = $putParams['section_id'];
        }
                
        
        $articleMapper->update($article);
        
        $this->getResponse()
                ->setHttpResponseCode(200);
        
    }
    
    public function deleteAction()
    {
        $articleMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_ARTICLE);
        
        if ($articleMapper->delete($this->_request->getParam('id'))==1) {
            $this->getResponse()
                ->setHttpResponseCode(200);
        }else {
             $this->getResponse()
                ->setHttpResponseCode(500);
        }
                
    }
}

?>