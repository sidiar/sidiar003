<?php

namespace AMC;

require_once dirname(__FILE__) . '/../../MAGAZINE/Magazine/Abstract.php';
require_once dirname(__FILE__) . '/../Content/Article.php';
require_once dirname(__FILE__) . '/../Content/Diapo.php';

/**
 * ConcreteFactory para crear familia de objetos para la revista online amomicasa.com
 *
 * Implementación de un Abstract Factory Pattern (Gof). 
 * Funciona como un singletone ya que solo se requiere una instancia. 
 * 
 * @package AMC
 * @author ariel
 * @link http://en.wikipedia.org/wiki/Abstract_factory_pattern
 */



class AMCFactory extends \Magazine\MagazineFactory {
    
    const CONTENTTYPE_ARTICLE = 'CONTENTTYPE_ARTICLE';
    const CONTENTTYPE_DIAPO = 'CONTENTTYPE_DIAPO';
    const CONTENTTYPE_LINK = 'CONTENTTYPE_LINK';
    
    
    /*
     * @var AMCFactory
     */
    private static $instancia;
    
    private function __construct() { }
    
    /*
     * Singletone getInstance method
     * 
     * @return AMCFactory
     */
    public static function getInstance() 
    {
        if (empty(self::$instancia)) {
            self::$instancia = new AMCFactory();
        }
        return self::$instancia;
    }
    
    public function makeSection()
    {
        
    }
    /**
     * Creator de contenidos
     * 
     * Implementación de un Factory Method Pattern (Gof) dentro de un Abstract Factory
     * 
     * @param string    $contentType
     * @throws InvalidArgumentException
     * @return AbstractContent
     */
    public function makeContent($contentType)
    {
        switch ($contentType) 
        {
            case self::CONTENTTYPE_ARTICLE:
                return new Article();
                break;
            case self::CONTENTTYPE_DIAPO:
                return new Diapo();
                break;
            case self::CONTENTTYPE_LINK:
                break;
            default:
                throw new InvalidArgumentException("$contentType is not a valid content type");
        
        }
    }
   
    public  function makeTAG()
    {
        
    }
    
    public  function makeContentRelation()
    {
        
    }
    
    public  function makeSearch()
    {
        
    }
    
    public  function makeNewsletter()
    {
        
    }
    
}
