<?php

namespace WebSyndication;

use \Patterns\Interfaces\ViewInterface;
use \WebSyndication\Abstracts\StdClass;

/**
 * Class to generate an HTML output from each syndication item type
 */
class Renderer
    implements ViewInterface
{

    protected $xml;
    protected $limit=null;
    protected $offset=0;

    public $options     = array();
    public $template    = null;
    public $content     = null;

    public function __construct($xml = null)
    {
        $this->xml = $xml;
    }

    public function __toString()
    {
        $this->render(
            $this
                ->guessTemplate()
                ->getTemplate($this->template),
            array(
                'xml'=>$this->xml,
                'limit'=>$this->getLimit(),
                'offset'=>$this->getOffset()
            )
        );
        return $this->content;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function guessTemplate()
    {
        if (!empty($this->template)) return;

        if (is_object($this->xml)) {
            if ($this->xml instanceof \WebSyndication\Feed) {
                $tpl_name = 'feed_channel_template';
            } elseif ($this->xml instanceof \WebSyndication\FeedsCollection) {
                $feeds = $this->xml->getFeedsRegistry();
                if (count($feeds)==1) {
                    $tpl_name = 'feed_channel_template';
                    $this->xml = $feeds[0];
                } else {
                    $tpl_name = 'feed_collection_template';
                }
            } elseif ($this->xml instanceof \WebSyndication\ItemsCollection) {
                $tpl_name = 'feed_collection_template';
            } else {
                $tpl_name = 'feed_item_template';
            }
        } else {
            $tpl_name = 'feed_collection_template';
        }

        $this->template = Helper::getTemplate($tpl_name);
        return $this;
    }

    /**
     * Building of a view content including a view file passing it parameters
     */
    public function render($view_file, array $params = array())
    {
        $this->content = Helper::renderView(
            $view_file,
            array_merge($this->getDefaultViewParams(), $params)
        );
    }

    /**
     * Get an array of the default parameters for all views
     */
    public function getDefaultViewParams()
    {
        return $this->options;
    }

    /**
     * Get a template file path
     */
    public function getTemplate($name)
    {
        return Helper::getTemplate($name);
    }

}

// Endfile