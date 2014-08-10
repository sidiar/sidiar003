<?php

namespace AMC;

require_once dirname(__FILE__) . '/../../MAGAZINE/ContentMapper/AbstractContentMapper.php';

/**
 * Description of DiapoMapper
 *
 * @package AMC
 * @author ariel
 * @see http://martinfowler.com/eaaCatalog/concreteTableInheritance.html
 */
class DiapoMapper extends \Magazine\AbstractContentMapper 
{
        
    protected function getTableName() 
    {
        return 'diapo';
    }
    
    
    /*
     * Maps row properties to domainObject properties
     * Called from Abstract Find() method
     * 
     * @param Zend_Db_Table_Row $row
     * @return \AMC\Diapo
     */
    protected function load($row) 
    {
        $diapo = new \AMC\Diapo();
        
        /* diapo is passed by reference */
        parent::abstractLoad($diapo, $row);
        
        /*
        $diapo-> = $row->;
         */
        
        return $diapo;
    }
    
    
    /*
     * Crea un array asociativo con los campos no vacíos del contenido
     * 
     * Aqui aprovechamos la funcionalidad del Zend Table Gateway que solo guarda los campos 
     * que pasamos como parámetro en el array asociativo.
     * 
     * @param \Magazine\Content       $content
     * @return associative_array
     */
    protected function save($diapo) 
    {
        $result = array();
        
        if (!empty($diapo->id)) {
            $result['content_id'] = $diapo->id;
        }
        
        return $result;
        
    }
}
