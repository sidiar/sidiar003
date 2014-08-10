<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  Consulte este Post para hacer esto...
 * 
 *  http://cvuorinen.net/2012/10/model-testing-using-sqlite-in-memory-database-with-zend-framework/
 *  http://phpunit.de/manual/3.7/en/database.html
 * 
 */

    

/**
 * Description of DatabaseTestCase
 *
 * @author ariel
 */
abstract class My_Test_PHPUnit_DatabaseTestCase extends PHPUnit_Extensions_Database_TestCase
{
/**
     * This can be overridden when extending this class.
     * @var mixed Bootstrap resources required by the test.
     *            String for a single resource or array for multiple resources.
     */
    protected $bootstrapResources;
 
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $dbAdapter;
 
    /**
     * Path to current schemafile
     * @var string
     */
    protected $schemaFile;
 
    /**
     * @var PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    protected $conn = null;
 
    /**
     * @var Zend_Application_Bootstrap_Bootstrap
     */
    protected $bootstrap;
 
    /**
     * Create databse connection and load schema file
     *
     * @return PDO Database connection
     */
    final public function getConnection()
    {
        if (null === $this->conn) {
            $this->conn = $this->createDefaultDBConnection($this->dbAdapter->getConnection());
            Zend_Db_Table_Abstract::setDefaultAdapter($this->dbAdapter);
            // $this->conn->getConnection()->exec(file_get_contents($this->schemaFile));
        }
 
        return $this->conn;
    }
 
    /**
     * Bootstrap application and required resources + create database adapter.
     */
    protected function setUp()
    {
        // Set configuration files
        $config = array(APPLICATION_PATH . '/configs/application.ini');
        if (file_exists(APPLICATION_PATH . '/configs/local.ini'))
            $config[] = APPLICATION_PATH . '/configs/local.ini';
 
        // Create application
        $application = new Zend_Application(
            APPLICATION_ENV,
            array('config' => $config)
        );
 
        // Bootstrap required resources.
        $application->bootstrap(array('config', 'db'));
        if (!empty($this->bootstrapResources)) {
            $application->bootstrap($this->bootstrapResources);
        }
 
        // Store bootstrap so we can later get resources from it.
        $this->bootstrap = $application->getBootstrap();
 
        $this->dbAdapter = $this->bootstrap->getPluginResource('db')->getDbAdapter();
        
       // $options = $this->bootstrap->getOptions();
       // $this->schemaFile = $options['resources']['multidb']['testdb']['testschema']['file'];
        // $this->schemaFile = $options['resources']['db']['params']['testschema']['file'];
 
        parent::setUp();
    }
}
