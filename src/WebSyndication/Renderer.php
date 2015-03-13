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

use \Patterns\Interfaces\ViewInterface;
use \WebSyndication\Abstracts\StdClass;

/**
 * Class to generate an HTML output from each syndication item type
 *
 * @author  piwi <me@e-piwi.fr>
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