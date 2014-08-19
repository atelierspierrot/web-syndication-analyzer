<?php

namespace RSS;

use \SimpleXMLElement;
use \RSS\Abstracts\XMLDataObject;
use \RSS\Abstracts\ParserInterface;
use \RSS\Feed;

class Parser
    extends XMLDataObject
    implements ParserInterface
{


    protected static $_debug = false;
    protected $feed; // original object of class \RSS\Feed

    public function __construct(SimpleXMLElement $xml, Feed $feed, $tag_name = null)
    {
        $this
            ->setXml($xml)
            ->setFeed($feed);
        if (!empty($this->xml)) $this->parse($tag_name);
    }

// -------------------
// Getters / Setters / Checkers
// -------------------

    public function setFeed(Feed $feed)
    {
        $this->feed = $feed;
        return $this;
    }

    public function getFeed()
    {
        return $this->feed;
    }

// -------------------
// Parsers
// -------------------

    public function parse($tag_name = null)
    {
        $namespaces = $this->feed->getNamespaces();
        $specs = \RSS\Helper::getSpecifications( $this->feed->getProtocol(), $this->feed->getVersion() );
        if (!empty($tag_name) && isset($specs[$tag_name])) {

//if (self::$_debug) echo '<br />specs : '.var_export($specs,1);
//if (self::$_debug) echo '<br />XML : '.var_export($this->getXml(),1);

            foreach($specs[$tag_name] as $var=>$spe) {
                $tagval = self::parseTag( $this->getXml(), $var, $spe, $specs );
                if ($tagval) {
                    if (isset($spe['rename'])) {
                        $var = $spe['rename'];
                    }
                    if (self::$_debug) echo '<br />adding data for tag name "'.$var.'" : '.var_export($tagval,1);
                    $this->addData($var, $tagval);
                }
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf('RSS parser method requires a valid tag name argument (got "%s")!', $tag_name)
            );
        }

        if (self::$_debug) echo '<hr />finally got data : '.var_export($this->getData(),1);
        return $this->getData();
    }

    public static function parseTag(
        $xml, $tag_name, array $tag_specifications,
        array $global_specifications, $is_attribute=false
    ) {

        if (self::$_debug) echo '<hr /><br />tag name : "'.$tag_name.'" with specs '.var_export($tag_specifications,1); //.' on value '.var_export($xml,1);

        // type of the field
        if (isset($tag_specifications['type'])) {
            $field_type = $tag_specifications['type'];
        }
        // else unknown type : exception
        else {
            throw new \LogicException(
                sprintf('Type not defined for tag_name "%s"!', $tag_name)
            );
        }

        // the field settings
        $field_settings = isset($tag_specifications['settings']) ? explode(',', $tag_specifications['settings']) : null;

        // the field value
        $value=null;
        if (false===$is_attribute && isset($xml->$tag_name)) {
            if ($field_type==='list') {
                $value = array();
                for($i=0; $i<count($xml->{$tag_name}); $i++) {
                    $value[] = $xml->{$tag_name}[$i];
                }
            } else {
                $value = $xml->$tag_name;
            }
        } elseif (true===$is_attribute) {
            $value = \RSS\Helper::getAttribute($xml, $tag_name);
        } elseif (isset($tag_specifications['default'])) {
            $value = $tag_specifications['default'];
        }

        // parsing            
        if ($value) {
            // other specification for this field type ?
            if (isset($global_specifications[$field_type])) {
                $field = new \RSS\Abstracts\StdClass;

//                $field->type = $type;
                $field->type = $field_type;

                foreach($global_specifications[$field_type] as $f_name=>$f_specs) {
                    if ($f_name==='content' && !isset($value->content)) {
                        $f_name = $tag_name;
                        $value = $xml;
                    }
                    $tag = self::parseTag(
                        $value, $f_name, $f_specs, $global_specifications, 
                            (isset($f_specs['attribute']) && $f_specs['attribute']==='1')
                    );
                    if (!is_null($tag)) {
                        $field->{$f_name} = $tag;
                    }
                }
                if (self::$_debug) echo '<br />=> special object : '.var_export($field,1);
            }

            // RSS_Field object
            else {
                if ($field_type==='list' && isset($tag_specifications['listitem_type'])) {
                    $field_settings['listitem_type'] = $tag_specifications['listitem_type'];
                }
                if (isset($tag_specifications['rename'])) {
                    $tag_name = $tag_specifications['rename'];
                }
                $field = new \RSS\Item( $field_type, $value, $tag_name, $field_settings );
                if (self::$_debug) echo '<br />=> object : '.var_export($field,1);
            }
            
            return $field;
        }

        elseif (isset($tag_specifications['required']) && $tag_specifications['required']==='1' && self::$_debug) {
            throw new \RuntimeException(
                sprintf('Required field "%s" is empty!', $tag_name)
            );
        }
        return null;
    }

}

// Endfile