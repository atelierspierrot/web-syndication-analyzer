<?php

namespace RSS\Abstracts;

use \RSS\Abstracts\ItemsContainerInterface;

/**
 * A specific standard class definition
 */
class StdClass
    implements ItemsContainerInterface
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
        return \RSS\Helper::findTagByCommonName($this, $tag_name);
    }

}

// Endfile