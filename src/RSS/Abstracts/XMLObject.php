<?php

namespace RSS\Abstracts;

use \SimpleXMLElement;
use \RSS\Abstracts\SimpleObject;

/**
 * The simplest RSS object entity with XML data
 */
class XMLObject
    extends SimpleObject
{

// -------------------
// XML Content
// -------------------

    protected $xml=null;

    public function setXml(SimpleXMLElement $xml)
    {
        $this->xml = $xml;
        return $this;
    }

    public function getXml()
    {
        return $this->xml;
    }

    public function exists()
    {
        return (bool) (count($this->xml) > 0);
    }

}

// Endfile