<?php

namespace WebSyndication\Abstracts;

use \SimpleXMLElement;
use \WebSyndication\Abstracts\XMLDataObject;
use \WebSyndication\Abstracts\ItemsContainerInterface;

/**
 * A collection helper for XML objects
 */
class XMLObjectsCollection
    extends XMLDataObject
    implements \Iterator, ItemsContainerInterface
{

    protected $position=0;
    protected $collection;

    public function __construct( $items )
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
        foreach($this->getCollection() as $_item) {
            $str .= $_item->__toString();
        }
        return $str;
    }
    
    public function getTagItem( $tag_name )
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
            for($i=0; $i<count($collection->item); $i++) {
                $table[] = $collection->item[$i];
            }
        } elseif (!empty($collection->entry)) {
            for($i=0; $i<count($collection->entry); $i++) {
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

