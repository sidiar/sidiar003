<?php

namespace AMC;

require_once 'ArticleMapper.php';
require_once 'DiapoMapper.php';

/**
 * Define un factory para crear los Mappers de cada tipo de contenido para amomicasa.com
 *
 * @package AMC
 * @author ariel
 * 
 */
class ContentMapper {
    
    const CONTENTTYPE_ARTICLE = 'CONTENTTYPE_ARTICLE';
    const CONTENTTYPE_DIAPO = 'CONTENTTYPE_DIAPO';
    const CONTENTTYPE_LINK = 'CONTENTTYPE_LINK';
 
    static function getInstance($contentType)
    {
        switch ($contentType) 
        {
            case self::CONTENTTYPE_ARTICLE:
                return new ArticleMapper();
            case self::CONTENTTYPE_DIAPO:
                return new DiapoMapper();
                break;
            case self::CONTENTTYPE_LINK:
                break;
            default:
                throw new InvalidArgumentException("$contentType is not a valid content type");
        
        }
    }
    
}
