<?php

require_once APPLICATION_PATH . '/../library/AMC/Magazine/AMCFactory.php';

require_once APPLICATION_PATH . '/../library/AMC/ContentFinder/ArticleQueryBuilder.php';
require_once APPLICATION_PATH . '/../library/MAGAZINE/ContentFinder/ContentFinder.php';
require_once APPLICATION_PATH . '/../library/AMC/ContentMapper/ContentMapper.php';

require_once APPLICATION_PATH . '/../library/AMC/Section/SectionCollection.php';

class ArticlesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Desactivo layout porque cargo el contenido via ajax */
        $this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
      //  error_reporting(E_ALL);
     //   ini_set("display_errors", 1); 
        
        /* filters */
        $filters = array();
        
        /* text search */
        if ($this->_request->getParam('text')) {
            $filters['text'] = $this->_request->getParam('text');
        }
        
        /* section */
        if ($this->_request->getParam('section_id')) {
            if ($this->_request->getParam('section_id')!='-1') {
                $filters['section_id'] = $this->_request->getParam('section_id');
            }
        }
        
        /* query builder */
        $this->articleQBuilder = new \AMC\ArticleQBuilder();
        
        \Magazine\ContentFinder::createQuery($this->articleQBuilder,$filters);
        $findQuery = $this->articleQBuilder->getQuery();
        
        /* paginator */
        $pag_adapter = new Zend_Paginator_Adapter_DbTableSelect($findQuery);
        $results = new Zend_Paginator($pag_adapter);        
        $results->setItemCountPerPage(7);
        
        if ($this->_request->getParam('page')) {
            $results->setCurrentPageNumber($this->_request->getParam('page'));
        }else{
            $results->setCurrentPageNumber(1);
        }

        
        /* 
         * section list     
         */
        $sectionCollection =  new SectionCollection();
        $sections = $sectionCollection->getSections();
        /*
        $sectionTableGateway = new \Zend_Db_Table('section');
        $sectionsQuery = $sectionTableGateway->select()->setIntegrityCheck()
                ->from('section','*')
                ->order('name');
        $sections = $sectionTableGateway->fetchAll($sectionsQuery);
        */
        
        $this->view->assign(array('results' => $results, 'paginator' => $results, 'filters' => $filters, 'sections' => $sections  ));
        
    }

    public function editAction()
    {
        if ($this->_request->getParam('id')) {
            $article_id = $this->_request->getParam('id');
        }
        
        //$amcFactory = AMC\AMCFactory::getInstance();
       // $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        $articleMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_ARTICLE);
        
        
        $article = $articleMapper->find($article_id);
        
        


         /* 
         * section list     
         */
        $sectionCollection =  new SectionCollection();
        $sections = $sectionCollection->getSections();
        
        // echo var_dump($article);
        
        $this->view->assign(array('article' => $article, 'sections' => $sections ));
        
    }
/*
    public function newAction()
    {
        
        $amcFactory = AMC\AMCFactory::getInstance();
        $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        
        $article->creation_date = date('Y-m-d');
        $article->expires = false;
        
        
       
        $sectionCollection =  new SectionCollection();
        $sections = $sectionCollection->getSections();
        
        $this->_helper->viewRenderer->setRender('edit'); 
                
        $this->view->assign(array('article' => $article, 'sections' => $sections ));
    }*/
}