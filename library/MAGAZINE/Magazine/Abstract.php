<?php

namespace Magazine;

/**
 * Define una interface para crear una familia de objetos de una revista online
 * 
 * Implementación de un Abstract Factory Pattern (Gof).
 * 
 * @package Magazine
 * @author ariel
 * @see http://en.wikipedia.org/wiki/Abstract_factory_pattern
 */


abstract class MagazineFactory {

    abstract function makeSection();
    
    abstract function makeContent($contentType);
    
    abstract function makeTAG();
    
    abstract function makeContentRelation();
    
    abstract function makeSearch();
    
    abstract function makeNewsletter();
    
}
