<?php

namespace RSS;

use \RSS\Feeds_Reader_App_Dependent;

/**
 * The global \RSS\Reader object as a singleton instance
 */
class Reader
    extends Feeds_Reader_App_Dependent
{

    protected $feeds_collection = array();
    protected $feeds_registry = array();
    
    function __construct($feeds_collection = null)
    {
        if (empty($feeds_collection)) {
            throw new InvalidArgumentException(
                sprintf('Creation of a "%s" instance with no feeds collection is not allowed!', __CLASS__)
            );
        }
        if (!is_array($feeds_collection)) $feeds_collection = array( $feeds_collection );
        $use_cache = $this->getRssReaderApp()->getOption('use_cache');
        if (true===$use_cache) {
            APP_Helper::makeDir( $this->getCacheDirname() );
        }
        $this
            ->setFeedsCollection($feeds_collection)
            ->createRegistry();
    }

    function __destruct()
    {
        $use_cache = $this->getRssReaderApp()->getOption('use_cache');
        if (true===$use_cache) {
            foreach($this->feeds_registry as $name=>$feed) {
                if (!self::isCached($feed->getFeedUrl())) {
                    $this->cache($feed, $feed->getFeedUrl());
                }
            }
        }
    }

// -------------------
// Getters / Setters / Checkers
// -------------------

    function setFeedsCollection(array $collection)
    {
        $this->feeds_collection = $collection;
        return $this;
    }

    function getFeedsCollection()
    {
        return $this->feeds_collection;
    }

    function countFeedsCollection()
    {
        return count($this->feeds_collection);
    }

    function getFeedItemIndex($url)
    {
        return array_search($url, $this->feeds_collection);
    }

    function getFeedById($id)
    {
        foreach($this->feeds_registry as $_feed) {
            if (isset($_feed->id) && $_feed->id===$id) {
                return $_feed;
            }
        }
        return null;
    }

    function getItemById($id)
    {
        $id_parts = explode('_', $id);
        if (count($id_parts)) {
            $feed = $this->getFeedById($id_parts[0]);
            if ($feed) {
                $feed->read();
                return $feed->getItemById($id);
            }
        }
        return null;
    }

    function getFeedsRegistry()
    {
        return $this->feeds_registry;
    }

    function getFeed( $url )
    {
        $index = $this->getFeedItemIndex($url);
        if (!empty($index) && array_key_exists($index, $this->feeds_registry)) {
            return $this->feeds_registry[$index];
        }
        return null;
    }

// -------------------
// Registry
// -------------------

    protected function createRegistry()
    {
        $use_cache = $this->getRssReaderApp()->getOption('use_cache');
        $this->feeds_registry = array();
        foreach($this->feeds_collection as $i=>$_feed_url) {
            $_url = (true===$use_cache && self::isCached($_feed_url)) ? 
                APP_Helper::getCacheFilepath($this->getCacheFilename($_feed_url)) : $_feed_url;
            $this->feeds_registry[$i] = new \RSS\Feed($_feed_url, $i);
        }
    }

    public function forceRefresh( $feed_url )
    {
        $index = $this->getFeedItemIndex($feed_url);
        if ($index) {
            $this->feeds_registry[$i] = new \RSS\Feed($this->feeds_collection[$index], $index);
        }
    }

// -------------------
// Cache Manager
// -------------------

    public function cache($feed_object, $feed_url)
    {
        if (!empty($feed_object) && $feed_object->getXml()!==null) {
            return APP_Helper::cache(
                $feed_object->getXml()->asXML(), $this->getCacheFilename($feed_url)
            );
        }
        return false;
    }

    public function isCached($feed_url)
    {
        return APP_Helper::isCached( $this->getCacheFilename($feed_url) );
    }

    public function getCacheDirname()
    {
        return 
            rtrim($this->getRssReaderApp()->getOption('temporary_directory'), '/').'/'
            .rtrim($this->getRssReaderApp()->getOption('feeds_cache_directory'), '/').'/';
    }

    public function getCacheFilename($feed_url)
    {
        return 
            rtrim($this->getRssReaderApp()->getOption('feeds_cache_directory'), '/').'/'
            .sprintf($this->getRssReaderApp()->getOption('cache_filename_mask','%s.txt'), md5($feed_url));
    }

}

// Endfile