<?php

namespace RSS;

use \RSS\Abstracts\DataObject;
use \RSS\Abstracts\Parser_Interface;
use \RSS\Abstracts\Reader_Interface;
use \RSS\Abstracts\ItemsContainer_Interface;

class Feed
    extends DataObject
    implements Parser_Interface, Reader_Interface, ItemsContainer_Interface
{

    protected $feed_url;
    protected $feed_name;
    protected $items;
    protected $namespaces;
    public $id;

    public function __construct($feed_url, $feed_name = null)
    {
        $this
            ->setFeedUrl($feed_url)
            ->setFeedName($feed_name);
    }

// -------------------
// Getters / Setters / Checkers
// -------------------

    public function getChannel()
    {
        return $this->getData();
    }

    public function hasItems($limit = null, $offset = 0)
    {
        return (count($this->items->getData($limit, $offset))>0);
    }

    public function getItemsCount()
    {
        return $this->items->count();
    }

    public function getItems($limit = null, $offset = 0)
    {
        return $this->items->getData($limit, $offset);
    }

    public function getItemById($id)
    {
        foreach($this->items->getData() as $_item) {
            if (isset($_item->id) && $_item->id===$id) {
                return $_item;
            }
        }
        return null;
    }

    public function getItemsCategories($limit = null, $offset = 0)
    {
        $items = $this->getItems($limit, $offset);
        $categories = array();
        foreach($items as $i=>$item) {
            $_cats = $item->getTagItem('category');
            if ($_cats && is_array($_cats->content)) {
                foreach($_cats->content as $j=>$_cat) {
                    $cat_label = ($_cat->hasAttribute('term') ? $_cat->getAttribute('term') : $_cat->content);
                    if (!in_array($_cat, $categories)) {
                        $categories[] = $cat_label;
                    }
                }
            }
        }
        return $categories;
    }

    public function getItem($index)
    {
        return isset($this->items->data[$index]) ? $this->items->data[$index] : null;
    }

    public function getItemsCollection()
    {
        return $this->items->getCollection();
    }

    public function setFeedUrl($feed_url)
    {
        $this->feed_url = $feed_url;
        $this->id = RSS_Helper::encodeStringToId( $this->feed_url );
        return $this;
    }

    public function getFeedUrl()
    {
        return $this->feed_url;
    }

    public function setFeedName($feed_name)
    {
        $this->feed_name = $feed_name;
        return $this;
    }

    public function getFeedName()
    {
        return $this->feed_name;
    }

// -------------------
// RSS ItemContainer Interface
// -------------------

    public function __toString()
    {
        $str = $this->getFeedName();
        foreach($this->items as $_item) {
            $str .= PHP_EOL.$_item->__toString();
        }
        return $str;
    }
    
    public function getTagItem($tag_name)
    {
        $tags = $this->getData();
        $found = RSS_Helper::findTagByCommonName( $tags, $tag_name );
        if (!empty($found)) {
            return $found;
        } else {
            return $this->items->getTagItem($tag_name);
        }
    }

// -------------------
// RSS Reader Interface
// -------------------

    public function read()
    {
        try {
            $this->setXml( new SimpleXMLElement($this->getFeedUrl(), 0, true) );
        } catch(Exception $e) {
            throw new RuntimeException( 'An error occurred while trying to read URL '.$this->getFeedUrl().' : '.$e->getMessage() );
        }
        if (RSS_Helper::readProtocol($this->xml)) {
            $this->setProtocol( RSS_Helper::readProtocol($this->xml) );
        }
        if (RSS_Helper::readVersion($this->xml)) {
            $this->setVersion( RSS_Helper::readVersion($this->xml) );
        }
        if (RSS_Helper::readNamespaces($this->xml)) {
            $this->setNamespaces( RSS_Helper::readNamespaces($this->xml) );
        }
        if (!empty($this->xml)) $this->parse();
    }

// -------------------
// RSS Parser Interface
// -------------------

    public function parse()
    {
        if ($this->getProtocol()==='RSS') {
            // channel
            $parser = new \RSS\Parser( $this->xml->channel, $this, 'channel' );
            $channel = $parser->getData();
            $channel->protocol = strtolower($this->getProtocol());
            $this->setData( $channel );
    
            // items
            $this->items = new \RSS\Abstracts\XMLObjectsCollection( $this->xml->channel );
            foreach($this->items as $i=>$item) {
                $parser = new \RSS\Parser( $item, $this, 'item' );
                $item = $parser->getData();
                $item->protocol = strtolower($this->getProtocol());
                $item->id = $this->id.'_'.RSS_Helper::encodeStringToId( $item->title->content );
                $this->items->addData( $i, $item );
            }

        } elseif ($this->getProtocol()==='ATOM') {
            // entry
            $parser = new \RSS\Parser( $this->xml, $this, 'feed' );
            $channel = $parser->getData();
            $channel->protocol = strtolower($this->getProtocol());
            $this->setData( $channel );
    
            // entry
            $this->items = new \RSS\Abstracts\XMLObjectsCollection( $this->xml );
            foreach($this->items as $i=>$item) {
                $parser = new \RSS\Parser( $item, $this, 'feed' );
                $item = $parser->getData();
                $item->protocol = strtolower($this->getProtocol());
                $item->id = $this->id.'_'.RSS_Helper::encodeStringToId( $item->title->content );
                $this->items->addData( $i, $item );
            }
        }
    }

}

// Endfile