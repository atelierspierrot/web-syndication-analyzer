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

    protected $item;

    public $options     = array();
    public $template    = null;
    public $content     = null;

    public function __construct($item = null)
    {
        $this->item = $item;
        $this->render(
            $this
                ->guessTemplate()
                ->getTemplate($this->template),
            array('xml'=>$this->item)
        );
    }

    public function __toString()
    {
        return $this->content;
    }

    public function guessTemplate()
    {
        if (!empty($this->template)) return;

        if ($this->item instanceof \WebSyndication\Feed) {
            $this->template = Helper::getTemplate('feed_channel');
        } else {
            $this->template = Helper::getTemplate('feed_item');
        }
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
     * Get a template file path (relative to `option['templates_dir']`)
     */
    public function getTemplate($name)
    {
        return Helper::getTemplate($name);
    }

}

// Endfile