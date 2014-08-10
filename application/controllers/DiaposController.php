<?php

require_once APPLICATION_PATH . '/../library/AMC/Magazine/AMCFactory.php';

require_once APPLICATION_PATH . '/../library/AMC/ContentFinder/DiapoQueryBuilder.php';
require_once APPLICATION_PATH . '/../library/MAGAZINE/ContentFinder/ContentFinder.php';
require_once APPLICATION_PATH . '/../library/AMC/ContentMapper/ContentMapper.php';




class DiaposController extends Zend_Controller_Action
{

    public function init()
    {
        /* Desactivo layout porque cargo el contenido via ajax */
        $this->_helper->layout()->disableLayout();
    }
    public function indexAction()
    {

        /* filters */
        $filters = array();
        
        /* text search */
        if ($this->_request->getParam('text')) {
            $filters['text'] = $this->_request->getParam('text');
        }
        
        /* query builder */
        $this->diapoQBuilder = new \AMC\DiapoQBuilder();
        
        \Magazine\ContentFinder::createQuery($this->diapoQBuilder,$filters);
        $findQuery = $this->diapoQBuilder->getQuery();
        
        /* paginator */
        $pag_adapter = new Zend_Paginator_Adapter_DbTableSelect($findQuery);
        $results = new Zend_Paginator($pag_adapter);        
        $results->setItemCountPerPage(7);
        
        if ($this->_request->getParam('page')) {
            $results->setCurrentPageNumber($this->_request->getParam('page'));
        }else{
            $results->setCurrentPageNumber(1);
        }

        
        
        $this->view->assign(array('results' => $results, 'paginator' => $results, 'filters' => $filters ));

    }


    public function editAction()
    {
        if ($this->_request->getParam('id')) {
            $diapo_id = $this->_request->getParam('id');
        }
        
        //$amcFactory = AMC\AMCFactory::getInstance();
       // $article = $amcFactory->makeContent(AMC\AMCFactory::CONTENTTYPE_ARTICLE);
        $diapoMapper = \AMC\ContentMapper::getInstance(\AMC\ContentMapper::CONTENTTYPE_DIAPO);
        
        
        $diapo = $diapoMapper->find($diapo_id);
        
        


        
        $this->view->assign(array('diapo' => $diapo ));
        
    }
}

