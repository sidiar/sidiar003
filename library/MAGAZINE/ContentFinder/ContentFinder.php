<?php

namespace Magazine;


/**
 * Construye una query de contenidos utilizando la interface ContentQueryBuilder
 * 
 * Su objetivo es utilizar el mismo proceso de creación de queries para todos los tipos de búsqueda de contenidos.
 * En el Builder pattern  cumple el rol del Director
 * 
 * @author  ariel
 * @link    http://en.wikipedia.org/wiki/Builder_pattern GoF
 * @package Magazine
 */

class ContentFinder {
    
     /**
     * Crea una consulta utilizando la interface ContentQueryBuilder en el objeto recibido y aplica filtros y ordenamientos.
     * 
     * Verifica qué filtros se deben aplicar y los ejecuta en el Builder.
     * 
     * @param ContentQueryBuilder $contentQBuilder   Objeto que construye la consulta. El objeto ser recibo por referencia.
     * @param array $filters    Array Asociativo: Las claves son los tipos de filtros y los valores a aplicar
     * @param array $order_criteria    String
     */
    static function createQuery(&$contentQBuilder,$filters=array(),$order_criteria=null) {
        
        $contentQBuilder->clearFilters();
        
        /* -- Apply filters -- */
        
        if (!empty($filters['text'])) {
            $contentQBuilder->applyFilter($contentQBuilder::FILTER_TEXT, $filters['text']);
        }
        
        if (!empty($filters['section_id'])) {
            $contentQBuilder->applyFilter($contentQBuilder::FILTER_SECTION, $filters['section_id']);
        }
        
        /* -- Order by -- */
        
        if (!empty($order_criteria)) {
            $contentQBuilder->clearOrder();
            $contentQBuilder->applyOrder($order_criteria);
        }
        
    }
}
