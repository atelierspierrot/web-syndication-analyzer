<?php

namespace RSS;

use \Patterns\Interfaces\ViewInterface;
use \RSS\Abstracts\StdClass;

/**
 * Class to generate an HTML output from each RSS item type
 */
class Renderer
    implements ViewInterface
{

    protected $item;

    public $options     = array();
    public $template    = null;
    public $content     = null;

    public function __construct(StdClass $item = null)
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

        $this->template = 'content-entry-item.htm';
        return $this;


        switch($this->item->getType()) {
            case 'category': $this->template = 'tag-category.htm'; break;
            case 'date': $this->template = 'tag-date.htm'; break;
            case 'image': $this->template = 'tag-image.htm'; break;
            case 'person': $this->template = 'tag-person.htm'; break;
            default: $this->template = 'tag-content.htm'; break;
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