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

use \SimpleXMLElement;
use \WebSyndication\Abstracts\XMLDataObject;
use \WebSyndication\Abstracts\ItemsContainerInterface;

/**
 * A collection helper for XML objects
 *
 * @author  piwi <me@e-piwi.fr>
 */
class XMLObjectsCollection
    extends XMLDataObject
    implements \Iterator, ItemsContainerInterface
{

    protected $position=0;
    protected $collection;

    public function __construct($items)
    {
        if (is_array($items)) {
            $this->setCollection($items);
        } else {
            $this->extractCollection($items);
        }
        $this->position = 0;
    }

// -------------------
// ItemContainer Interface
// -------------------

    public function __toString()
    {
        $str='';
        foreach ($this->getCollection() as $_item) {
            $str .= $_item->__toString();
        }
        return $str;
    }
    
    public function getTagItem($tag_name)
    {
    }

// -------------------
// Collection getters / setters
// -------------------

    public function setCollection(array $collection)
    {
        $this->collection = $collection;
        return $this;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function add(SimpleXMLElement $item)
    {
        $this->collection->push($item);
        return $this;
    }

    public function extractCollection(SimpleXMLElement $collection)
    {
        $table = array();
        if (!empty($collection->item)) {
            for ($i=0; $i<count($collection->item); $i++) {
                $table[] = $collection->item[$i];
            }
        } elseif (!empty($collection->entry)) {
            for ($i=0; $i<count($collection->entry); $i++) {
                $table[] = $collection->entry[$i];
            }
        }
        return $this->setCollection($table);
    }

// -------------------
// Iterator Interface
// -------------------

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

// Special additions

    public function previous()
    {
        --$this->position;
    }

    public function exists()
    {
        return (bool) (count($this->collection) > 0);
    }

    public function count()
    {
        return count($this->collection);
    }
}
