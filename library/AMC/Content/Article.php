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

class Article extends \Magazine\Content 
{
    /*
     * @var integer
     */
    public $section_id;
    
    /*
     * @var string
     */
    public $intro;
    
    /*
     * @var string
     */
    public $fulltext;
    
    
    function getType_id()
    {
        return 1;
    }

    
    
}
