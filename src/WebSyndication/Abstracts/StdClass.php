<?php
/**
 * This file is part of the WebSyndicationAnalyzer package.
 *
 * Copyright (c) 2014-2016 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/web-syndication-analyzer>.
 */

namespace WebSyndication\Abstracts;

use \WebSyndication\Helper;
use \WebSyndication\Abstracts\ItemsContainerInterface;

/**
 * A specific standard class definition
 *
 * @author  piwi <me@e-piwi.fr>
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
        return Helper::findTagByCommonName($this, $tag_name);
    }
}
