<?php

namespace AMC;

require_once dirname(__FILE__) . '/../../MAGAZINE/ContentFinder/ContentQueryBuilder.php';


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiapoQueryBuilder
 *
 * @author ariel
 */
class DiapoQBuilder implements \Magazine\ContentQueryBuilder {

    const _CONTENT_TYPE_DIAPO = 2;
    

    /**
     * @var Zend_Db_Select
     */
    private $_query;
    
    function __construct() {
        
        $this->initQuery();
        
    }
    
    /**
     * Inicializa la consulta sin aplicar ningún tipo de filtro.
     * 
     * Puede ser llamado desde el constructor de la clase.
     */
    function initQuery() {

        $contentTableGateway = new \Zend_Db_Table('content');
        
        $this->_query = $contentTableGateway->select()->setIntegrityCheck(false)
                ->from(array('c' => 'content'),array(
                    'id'=>'c.id',
                    'status'=>'c.status',
                    'title' => 'c.title',
                    'publish_date_from' => 'c.publish_date_from',
                    'publish_date_to' => 'c.publish_date_to',
                    'expires' => 'c.expires',
                    'view_count' => 'c.view_count',
                    'share_count' => 'c.share_count'))
                ->where('c.type_id = ? ', self::_CONTENT_TYPE_DIAPO)
                ->order('c.title');

    }
    
    /**
     * Devuelve el objeto Zend_Db_Select de la consulta
     * 
     * @return Zend_Db_Select
     */
    function getQuery() {
        return $this->_query;
    }
    
    /**
     * Agrega un filtro a la consulta.
     * 
     * @param string $filter_type Tipo de filtro definido en las constantes de la interface \ContentQueryBuilder.
     * @param mixed $value Valor del filtro a aplicar.
     * @throws InvalidArgumentException Si el parámetro recibido no esta entre los filtros especificados en las constantes.
     */
    function applyFilter($filter_type, $value) {
        switch ($filter_type) {
            case self::FILTER_TEXT:
                $this->_query->where('c.title like ? OR c.text like ? ', '%' . $value . '%');
                break;

            default:
                throw new \InvalidArgumentException("$filter_type must be a valid order criteria");
            
        }
    }
    
    /**
     * Aplica un orden a la consulta.
     * 
     * @param string $order_criteria Tipo de orden definido en las constantes de la interface \ContentQueryBuilder.
     * @param mixed $value Valor del filtro a aplicar.
     * @throws InvalidArgumentException Si el parámetro recibido no esta entre los filtros especificados en las constantes.
     */
    function applyOrder($order_criteria) {
        
        switch ($order_criteria) {
            case self::ORDERBY_TITLE:
                $this->_query->order('c.title');
                break;

            case self::ORDERBY_PUBLISH_DATE_FROM:
                $this->_query->order('c.publish_date_from desc');
                break;

            case self::ORDERBY_VIEW_COUNT:
                $this->_query->order('c.view_count desc');
                break;

            case self::ORDERBY_SHARE_COUNT:
                $this->_query->order('c.share_count desc');
                break;
            
            default:
                throw new \InvalidArgumentException("$filter_type must be a valid order criteria");
            
        }
    }
    
    
    /**
     * Hace un reset de todos los filtros de la consulta.
     */
    function clearFilters() {
        $this->_query->reset('where');
        $this->_query->where('c.type_id = ? ', self::_CONTENT_TYPE_DIAPO);
    }
    
    /**
     * Hace un reset de todos orders de la consulta.
     */
    function clearOrder() {
        $this->_query->reset('order');
    }
    
    /**
     * Devuelve la cadena SQL de la consulta.
     * 
     * Se utiliza para facilitar el testing y debugging.
     */
    function __toString() {
        return $this->_query->__toString();
    }
}
