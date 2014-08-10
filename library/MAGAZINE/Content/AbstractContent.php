<?php

namespace Magazine;


/**
 * 
 * Define la interface que todos los tipos de contenidos de la revista deben implementar
 * 
 * Abstract que contiene propiedades y métodos comunes a todos los tipos de contenidos
 * En un Factory Method Pattern (Gof), sería el producto.
 * 
 * @author ariel
 * @package Magazine
 * @see http://en.wikipedia.org/wiki/Factory_method_pattern
 */


abstract class Content {
    
    /*
     * @var integer
     */
    public $id;
    
    /*
     * @var integer
     */
    public $status;
    
    /*
     * @var date
     */
    public $publish_date_from;
    
    /*
     * @var date
     */
    public $publish_date_to;
    
    /*
     * @var integer
     */
    
    public $view_count;
    
    /*
     * @var integer
     */
    
    public $share_count;
    
    /*
     * @var string
     */
    public $title;
    
    /*
     * @var string
     */
    public $text;
    
    
    
    
    /*
     * @return integer
     */    
    abstract function getType_id();
    
   
    
    
    
}
