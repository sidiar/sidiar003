<?php

require_once '/Users/ariel/magnet/Amomicasa/06_WWW/admin/library/AMC/Magazine/AMCFactory.php';
require_once '/Users/ariel/magnet/Amomicasa/06_WWW/admin/library/AMC/ContentFinder/ArticleQueryBuilder.php';
require_once '/Users/ariel/magnet/Amomicasa/06_WWW/admin/library/MAGAZINE/ContentFinder/ContentFinder.php';
require_once 'DatabaseTestCase.php';
        
/**
 * Description of ContentTest
 *
 * @author ariel
 */
/*
PHPUnit_Framework_TestCase
 *  */

class ContentFindTest  extends My_Test_PHPUnit_DatabaseTestCase {
    //put your code here
    
    private $amcFactory;
    
    private $articleQBuilder;
    
    
    public function setUp() {
        parent::setUp();
        $this->amcFactory = AMC\AMCFactory::getInstance();
    }
    
     protected function getDataSet()
    {
       
          $dataSet = new PHPUnit_Extensions_Database_DataSet_CsvDataSet();
          $dataSet->addTable('article', APPLICATION_PATH . '/../tests/data/csv/article.csv');
          $dataSet->addTable('content', APPLICATION_PATH . '/../tests/data/csv/content.csv');
          return $dataSet;
        
    }
    
    
    private function getArticlesFindResults($filters=array(),$order=null) {
        $this->articleQBuilder = new \AMC\ArticleQBuilder();
        
        \Magazine\ContentFinder::createQuery($this->articleQBuilder,$filters,$order);
        $findQuery = $this->articleQBuilder->getQuery();
        
        $contentTableGateway = new \Zend_Db_Table('content');
        $results = $contentTableGateway->fetchAll($findQuery);
        return $results;
    }
    
    public function testFindArticle() {
        
        $results = $this->getArticlesFindResults();

        $this->assertCount(12,$results);
        
        $art1 = $results->current();
        
        $this->assertEquals(5,$art1->id);
        $this->assertEquals('A quien tengo que llamar para hacer lo que no puedo hacer yo [5]',$art1->title);
        $this->assertEquals('Mi casa',$art1->section);
        $this->assertEquals(5,$art1->view_count);
        $this->assertEquals(1,$art1->status);
        $this->assertEquals(0,$art1->share_count);
        
    }
    
    public function testApplyFiltersArticle() {
        
        /* TEXT SEARCH */
        $filters = array('text' => 'muebles');
        
        $results = $this->getArticlesFindResults($filters);
        $this->assertCount(2,$results);
        
        /* SECTION */
        
        $filters = array('section_id' => 3);
        $results = $this->getArticlesFindResults($filters);
        $this->assertCount(8,$results);
        
        /* TEXT SEARCH + SECTION */
        $filters = array('section_id' => 3,'text' => 'muebles');
        $results = $this->getArticlesFindResults($filters);
        $this->assertCount(2,$results);
        
    }
    
    
    public function testOrderArticle() {
        
        /* ORDER BY SECTION NAME */
        $results = $this->getArticlesFindResults(array(),\AMC\ArticleQBuilder::ORDERBY_SECTION_NAME);

        $art1 = $results->current();
        $this->assertEquals('Mi casa',$art1->section);
        
        $art2 = $results->seek(11)->current();
        $this->assertEquals('Mis hijos',$art2->section);
        
        /* ORDER BY PUBLISH_DATE_FROM */
        $results = $this->getArticlesFindResults(array(),\AMC\ArticleQBuilder::ORDERBY_PUBLISH_DATE_FROM);

        $art1 = $results->current();
        $this->assertEquals(12,$art1->id);
        
        $art2 = $results->seek(11)->current();
        $this->assertEquals(1,$art2->id);
        
    }
    
    
    
    
    
}
