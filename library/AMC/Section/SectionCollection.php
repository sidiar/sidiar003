<?php
/**
 * Description of SectionCollection
 *
 * @author ariel
 */
class SectionCollection {

    /*
     * @var Zend_Db_Table
     */
    private $sectionTableGateway;
    
     /*
     * @var Zend_Cache
     */
    private $cache;
    
    
    function __construct() {
        
        /*
         * Inicializo el cache
         */
        
        $frontendOptions = array(
        'lifetime' => null, // cache lifetime of 2 hours
        'automatic_serialization' => true
        );

        $backendOptions = array(
        //'cache_dir' => '/usr/local/zend/tmp/' // Directory where to put the cache files
        );

        // getting a Zend_Cache_Core object
        $this->cache = Zend_Cache::factory('Core',
         'File',
         $frontendOptions,
         $backendOptions);

    }

    function getSections() {

        if (!$result = $this->cache->load('sectionCollection')) {

            $this->sectionTableGateway = new \Zend_Db_Table('section');
            $sectionsQuery = $this->sectionTableGateway->select()->setIntegrityCheck()
                    ->from('section', '*')
                    ->order('name');
            $result = $this->sectionTableGateway->fetchAll($sectionsQuery);



            $this->cache->save($result, 'sectionCollection');
        }
        
        return $result;
    }

}
