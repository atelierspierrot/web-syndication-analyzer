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

/**
 * The simplest syndication object entity
 */
class SimpleObject
{

// -------------------
// XML Protocol (RSS or ATOM), Version and Namespaces
// -------------------

    static $allowed_protocols = array(
        'rss'=>'rss',
        'atom'=>'atom',
        'feed'=>'atom'
    );

    protected $protocol=null; // uppercase
    protected $version=0; // float
    protected $namespaces=array();

    public function setProtocol($protocol)
    {
        if (!array_key_exists(strtolower($protocol), self::$allowed_protocols)) {
            throw new \InvalidArgumentException(
                sprintf('Unknown protocol "%s"!', $protocol)
            );
        }
        $this->protocol = strtoupper(self::$allowed_protocols[$protocol]);
        return $this;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setVersion($version)
    {
        $this->version = strtoupper($version);
        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces;
        return $this;
    }

    public function getNamespaces()
    {
        return $this->namespaces;
    }

    public function getNamespace($index)
    {
        return isset($this->namespaces[$index]) ? $this->namespaces[$index] : null;
    }

    public function hasNamespace($index)
    {
        return isset($this->namespaces[$index]);
    }

}

// Endfile