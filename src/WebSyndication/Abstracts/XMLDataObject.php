<?php
/**
 * This file is part of the WebSyndicationAnalyzer package.
 *
 * Copyright (c) 2014-2016 Pierre Cassat <me@e-piwi.fr> and contributors
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

namespace WebSyndication\Abstracts;

use \WebSyndication\Abstracts\XMLObject;
use \WebSyndication\Abstracts\StdClass as WebSyndicStdClass;

/**
 * The simplest syndication object entity with XML data and a set of data
 *
 * @author  piwi <me@e-piwi.fr>
 */
class XMLDataObject
    extends XMLObject
{

    // -------------------
// Data Content
// -------------------

    protected $data=null;

    protected function initData()
    {
        $this->data = new WebSyndicStdClass;
    }

    public function addData($name, $value)
    {
        if (is_null($this->data)) {
            $this->initData();
        }
        $this->data->{$name} = $value;
        return $this;
    }

    public function setData($data)
    {
        if (is_array($data)) {
            foreach ($data as $var=>$val) {
                $this->addData($var, $val);
            }
        } elseif (is_object($data)) {
            foreach (get_object_vars($data) as $var=>$def) {
                $this->addData($var, $data->$var);
            }
        }
        return $this;
    }

    public function getData($limit = null, $offset = 0)
    {
        if (!empty($limit)) {
            $data = array();
            if (is_object($this->data)) {
                for ($i=$offset; $i<=($offset+$limit); $i++) {
                    if (property_exists($this->data, $i)) {
                        $data[] = $this->data->{$i};
                    }
                }
            } elseif (is_array($this->data)) {
                $data = array_slice($this->data, $offset, $limit);
            }
            return $data;
        }
        return $this->data;
    }

    public function get($entry, $default = null)
    {
        if (is_null($this->data)) {
            $this->initData();
        }
        return isset($this->data->$entry) ? $this->data->$entry : $default;
    }

    public function set($entry, $value)
    {
        return $this->addData($entry, $value);
    }

    public function __get($entry)
    {
        return $this->get($entry);
    }

    public function __set($entry, $value)
    {
        return $this->set($entry, $value);
    }
}
