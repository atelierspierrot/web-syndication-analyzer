<?php

namespace RSS\Abstracts;

use \Patterns\Abstracts\AbstractOptionable;

/**
 * The simplest RSS object entity
 */
class SimpleObject
    extends AbstractOptionable
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