<?php
/**
 * This file is part of the WebSyndicationAnalyzer package.
 *
 * Copyright (c) 2014-2015 Pierre Cassat <me@e-piwi.fr> and contributors
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

namespace WebSyndication;

use \SimpleXMLElement;

use \WebSyndication\Helper;
use \WebSyndication\Abstracts\XMLDataObject;
use \WebSyndication\Abstracts\XMLObjectsCollection;
use \WebSyndication\Abstracts\ParserInterface;
use \WebSyndication\Abstracts\ReaderInterface;
use \WebSyndication\Abstracts\ItemsContainerInterface;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class Feed
    extends XMLDataObject
    implements ParserInterface, ReaderInterface, ItemsContainerInterface
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

    public function getRawXml()
    {
        return $this->getXml()->asXml();
    }

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

    public function getItemsCollectionByCategorie($category, $limit = null, $offset = 0)
    {
        $items = $this->getItems();
        $collection = array();
        foreach($items as $i=>$item) {
            $_cats = $item->getTagItem('category');
            if ($_cats && is_array($_cats->content)) {
                foreach($_cats->content as $j=>$_cat) {
                    $cat_label = ($_cat->hasAttribute('term') ? $_cat->getAttribute('term') : $_cat->content);
                    if ($cat_label==$category) {
                        $collection[] = $item;
                        continue 2;
                    }
                }
            }
        }
        return array_slice($collection, $offset, $limit);
    }

    public function setFeedUrl($feed_url)
    {
        $this->feed_url = $feed_url;
        $this->id = Helper::encodeStringToId( $this->feed_url );
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
// Syndication ItemContainer Interface
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
        $found = Helper::findTagByCommonName( $tags, $tag_name );
        if (!empty($found)) {
            return $found;
        } else {
            return $this->items->getTagItem($tag_name);
        }
    }

// -------------------
// Syndication Reader Interface
// -------------------

    public function read()
    {
        $proxy = Helper::getOption('proxy');
        if (is_null($proxy)) {
            $protocol = substr($this->getFeedUrl(), 0, 5)=='https' ? 'https' : 'http';
            $proxy = Helper::getOption('proxy_'.$protocol);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getFeedUrl());
        if (!is_null($proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        if (!empty($result)) {
            $this->_init($result)->parse();
        }
    }

    protected function _init($xml)
    {
        try {
            $this->setXml( new SimpleXMLElement($xml, 0, false) );
        } catch(\Exception $e) {
            throw new \RuntimeException( 'An error occurred while trying to load XML string '.$xml.' : '.$e->getMessage() );
        }
        if (Helper::readProtocol($this->xml)) {
            $this->setProtocol( Helper::readProtocol($this->xml) );
        }
        if (Helper::readVersion($this->xml)) {
            $this->setVersion( Helper::readVersion($this->xml) );
        }
        if (Helper::readNamespaces($this->xml)) {
            $this->setNamespaces( Helper::readNamespaces($this->xml) );
        }
        return $this;
    }

// -------------------
// Syndication Parser Interface
// -------------------

    public function parse()
    {
        if ($this->getProtocol()==='RSS') {
            // channel
            $parser                 = new Parser( $this->xml->channel, $this, 'channel' );
            $channel                = $parser->getData();
            $channel->protocol      = strtolower($this->getProtocol());
            $this->setData( $channel );
    
            // items
            $this->items            = new XMLObjectsCollection( $this->xml->channel );
            foreach ($this->items as $i=>$item) {
                $parser             = new Parser( $item, $this, 'item' );
                $item               = $parser->getData();
                $item->protocol     = strtolower($this->getProtocol());
                $item->id           = $this->id.'_'.Helper::encodeStringToId( $item->title->content );
                $this->items->addData( $i, $item );
            }

        } elseif ($this->getProtocol()==='ATOM') {
            // entry
            $parser             = new Parser( $this->xml, $this, 'feed' );
            $channel            = $parser->getData();
            $channel->protocol  = strtolower($this->getProtocol());
            $this->setData( $channel );
    
            // entry
            $this->items            = new XMLObjectsCollection( $this->xml );
            foreach ($this->items as $i=>$item) {
                $parser             = new Parser( $item, $this, 'feed' );
                $item               = $parser->getData();
                $item->protocol     = strtolower($this->getProtocol());
                $item->id           = $this->id.'_'.Helper::encodeStringToId( $item->title->content );
                $this->items->addData( $i, $item );
            }
        }
    }

}

// Endfile