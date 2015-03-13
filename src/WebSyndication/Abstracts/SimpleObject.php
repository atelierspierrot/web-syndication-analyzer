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

namespace WebSyndication\Abstracts;

/**
 * The simplest syndication object entity
 *
 * @author  piwi <me@e-piwi.fr>
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