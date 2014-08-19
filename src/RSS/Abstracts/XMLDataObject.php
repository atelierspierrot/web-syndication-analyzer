<?php

namespace RSS\Abstracts;

use \RSS\Abstracts\XMLObject;
use \RSS\Abstracts\StdClass as RSSStdClass;

/**
 * The simplest RSS object entity with XML data and a set of data
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
        $this->data = new RSSStdClass;
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