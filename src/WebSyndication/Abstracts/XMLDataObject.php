<?php
/**
 * This file is part of the WebSyndicationAnalyzer package.
 *
 * Copyleft (ↄ) 2014-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/web-syndication-analyzer>.
 */

namespace WebSyndication\Abstracts;

use \WebSyndication\Abstracts\XMLObject;
use \WebSyndication\Abstracts\StdClass as WebSyndicStdClass;

/**
 * The simplest syndication object entity with XML data and a set of data
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
            foreach($data as $var=>$val) {
                $this->addData($var, $val);
            }
        } elseif (is_object($data)) {
            foreach(get_object_vars($data) as $var=>$def) {
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
                for($i=$offset; $i<=($offset+$limit); $i++) {
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

// Endfile