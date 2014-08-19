<?php

namespace CachedRSS;

use \Patterns\Commons\Collection;

/**
 * The global \RSS\Reader object as a singleton instance
 */
class FeedCollection
    extends Collection
{

    protected $feeds_collection = array();
    protected $feeds_registry = array();

    /**
     * Construction of a collection
     *
     * @param   array|string   $feeds_collection    The array of the collection content (optional)
     */
    public function __construct($feeds_collection = array())
    {
        if (empty($feeds_collection)) {
            throw new \InvalidArgumentException(
                sprintf('Creation of a "%s" instance with no feeds collection is not allowed!', __CLASS__)
            );
        }
        if (!is_array($feeds_collection)) $feeds_collection = array( $feeds_collection );
        parent::__construct( $feeds_collection );
        $this->createRegistry();
    }

    public function __destruct()
    {
    }

// -------------------
// Getters / Setters / Checkers
// -------------------

    public function setFeedsCollection(array $collection)
    {
        $this->feeds_collection = $collection;
        return $this;
    }

    public function getFeedsCollection()
    {
        return $this->feeds_collection;
    }

    public function countFeedsCollection()
    {
        return count($this->feeds_collection);
    }

    public function getFeedItemIndex($url)
    {
        return array_search($url, $this->feeds_collection);
    }

    public function getFeedById($id)
    {
        foreach($this->feeds_registry as $_feed) {
            if (isset($_feed->id) && $_feed->id===$id) {
                return $_feed;
            }
        }
        return null;
    }

    public function getItemById($id)
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

    public function getFeedsRegistry()
    {
        return $this->feeds_registry;
    }

    public function getFeed( $url )
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
                \RSS\Helper::getCacheFilepath($this->getCacheFilename($_feed_url)) : $_feed_url;
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
            return \RSS\Helper::cache(
                $feed_object->getXml()->asXML(), $this->getCacheFilename($feed_url)
            );
        }
        return false;
    }

    public function isCached($feed_url)
    {
        return \RSS\Helper::isCached( $this->getCacheFilename($feed_url) );
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