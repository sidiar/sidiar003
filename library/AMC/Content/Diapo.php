<?php

namespace AMC;

require_once dirname(__FILE__) . '/../../MAGAZINE/Content/AbstractContent.php';

/**
 * 
 * Define un Artículo de tipo Content para la revista amomicasa.com
 * 
 * @package AMC
 * @author ariel
 */

class Diapo extends \Magazine\Content 
{
    
    
    function getType_id()
    {
        return 2;
    }

    
    
}
