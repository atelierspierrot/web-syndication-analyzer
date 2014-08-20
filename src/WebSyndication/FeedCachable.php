<?php

namespace WebSyndication;

use \SimpleXMLElement;
use \Patterns\Interfaces\CachableInterface;
use \WebSyndication\Helper;

/**
 */
class FeedCachable
    extends Feed
    implements CachableInterface
{

    protected $cache_key;

    public function __construct($feed_url, $feed_name = null)
    {
        parent::__construct($feed_url, $feed_name);
        $this->buildCacheKey();
    }

    public function read()
    {
        if ($this->isCached()) {
            $content = $this->getCache();
            if (!empty($content)) {
                $this->_init($content)->parse();
            }
        } else {
            $this->invalidateCache();
            parent::read();
            $this->setCache($this);
        }
    }

// -------------------
// Setter / Getter
// -------------------

    public function setCacheKey($str)
    {
        $this->cache_key = $str;
        return $this;
    }

    public function getCacheKey()
    {
        return $this->cache_key;
    }

// -------------------
// CachableInterface
// -------------------

    public function getCacheDirname()
    {
        $tmp_dir = Helper::getOption('cache_directory');
        if (empty($tmp_dir)) {
            $tmp_dir = sys_get_temp_dir();
        }
        return rtrim($tmp_dir, '/').'/';
    }

    /**
     * Get the key of the current cached item
     *
     * This should transform an item identifier (such as a title) into a uniq key.
     *
     * @return string
     */
    function buildCacheKey()
    {
        $this->setCacheKey(
            $this->getCacheDirname()
            .sprintf(Helper::getOption('cache_filename_mask','%s.xml'), md5($this->getFeedUrl()))
        );
        return $this;
    }

    /**
     * Test if an item is already cached and if its cache is still valid
     *
     * This may check if a cache exists for the item and if it seems always valid ; validity
     * may be tested for a static duration time (a `max_cache_time`) and could be checked
     * comparing the creation time of the cache entry and the last modification time of the
     * source if it is possible.
     *
     * @return bool
     */
    function isCached()
    {
        $cache_lifetime = Helper::getOption('cache_lifetime',0);
        if ($cache_lifetime>0) {
            return (@file_exists($this->getCacheKey()) && (filemtime($this->getCacheKey())+$cache_lifetime) > time());
        } else {
            return (@file_exists($this->getCacheKey()));
        }
    }

    /**
     * Get a cache content for an item
     *
     * This must return the exact same content passed at the `setCache()` method.
     *
     * @return mixed
     */
    function getCache()
    {
        if (@file_exists($this->getCacheKey())) {
            ob_start();
            include $this->getCacheKey();
            $cache = ob_get_contents();
            ob_end_clean();
            return $cache;
        }
        return null;
    }

    /**
     * Set a cache content for an item
     *
     * This must store the content in association with the item key ; the method could
     * return a boolean indicates if the caching process succeeded.
     *
     * @param mixed $content
     * @return bool
     */
    function setCache($content)
    {
        if (!empty($content) && $content->getXml()!==null) {
            return (!empty($content)) ?
                file_put_contents($this->getCacheKey(), $content->getXml()->asXML()) : false;
        }
        return false;
    }

    /**
     * Clear a cache content for an item
     *
     * This must clear the cached content associated with the item key ; the method could
     * return a boolean indicates if the deletion process succeeded.
     *
     * @return bool
     */
    function invalidateCache()
    {
        if (@file_exists($this->getCacheKey())) {
            @unlink($this->getCacheKey());
        }
        return true;
    }

}

// Endfile