<?php

namespace WebSyndication;

use \Patterns\Commons\Collection;
use \Patterns\Traits\Optionable;

use \WebSyndication\Feed;

/**
 * The global Feeds collection
 */
class FeedCollection
    extends Collection
{

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
    }

    public function __destruct()
    {
    }

    public function read()
    {
        $this->createRegistry();
    }

// -------------------
// Getters / Setters / Checkers
// -------------------

    public function getFeedItemIndex($url)
    {
        return array_search($url, $this->getCollection());
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
        $cachable = Helper::getOption('use_cache', false);
        $this->feeds_registry = array();
        foreach($this->getCollection() as $i=>$_feed_url) {
            $this->feeds_registry[$i] = $cachable ?
                new FeedCachable($_feed_url, $i)
                :
                new Feed($_feed_url, $i)
            ;
        }
    }

    public function forceRefresh( $feed_url )
    {
        $cachable = Helper::getOption('use_cache', false);
        $index = $this->getFeedItemIndex($feed_url);
        if ($index) {
            $this->feeds_registry[$i] = $cachable ?
                new FeedCachable($this->offsetGet($index), $index)
                :
                new Feed($this->offsetGet($index), $index)
            ;
        }
    }

}

// Endfile