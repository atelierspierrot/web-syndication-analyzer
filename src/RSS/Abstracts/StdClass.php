<?php

namespace RSS\Abstracts;

use \RSS\Abstracts\ItemsContainer_Interface;

/**
 * A specific standard class definition
 */
class StdClass
    implements ItemsContainer_Interface
{

    public function hasAttribute()
    {
        return false;
    }
    
// -------------------
// RSS ItemsContainer Interface
// -------------------

    public function __toString()
    {
        return '';
    }
    
    public function getTagItem($tag_name)
    {
        return RSS_Helper::findTagByCommonName($this, $tag_name);
    }

}

// Endfile