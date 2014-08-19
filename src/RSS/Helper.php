<?php

namespace RSS;

use \SimpleXMLElement;

/**
 * Helper class for RSS library
 */
class Helper
{

// -------------------
// Feeds specifications
// -------------------

    public static $specifications=array();

    public static function getSpecifications( $protocol, $version )
    {
        $specs_name = strtolower($protocol).( !empty($version) ? '-'.$version : '' );
        if (!isset(self::$specifications[$specs_name]))
        {
            $specs_file = rtrim(RSS_SPECS, '/').'/'.$specs_name.'.ini';

            $specs = @parse_ini_file($specs_file, true);
            if (!$specs) {
                throw new RuntimeException(
                    sprintf('Specifications file for protocol "%s" not found or is not a valid INI file! (searched in "%s"', $specs_name, $specs_file)
                );
            }
            if (isset($specs['common']))
            {
                foreach($specs as $tag=>$data)
                {
                    if ($tag!=='common')
                    {
                        $specs[$tag] = array_merge($specs['common'], $specs[$tag]);
                    }
                }
            }
            self::$specifications[$specs_name] = $specs;
        }
        return self::$specifications[$specs_name];
    }

// -------------------
// Feed informations
// -------------------

    public static function readProtocol( SimpleXMLElement $xml )
    {
        return $xml->getName();
    }
    
    public static function readVersion( SimpleXMLElement $xml )
    {
        foreach($xml->attributes() as $attr=>$attr_val)
        {
            if ($attr==='version') return $attr_val;
        }
        return null;
    }
    
    public static function readNamespaces( SimpleXMLElement $xml, $recursive=true )
    {
        return $xml->getNamespaces($recursive);
    }
    
// -------------------
// XMLObject informations
// -------------------

    public static $protocolsCorrespondance = array(
        'item_link'     =>array( 'item_link', 'link' ),
        'description'   =>array( 'description', 'summary' ),
        'image'         =>array( 'image', 'logo', 'icon' ),
        'updated_date'  =>array( 'pubDate', 'published', 'updated' ),
        'media'         =>array( 'enclosure', 'source' )
    );

    public static function findTagByCommonName( $xml, $tag_name )
    {
        $found = null;
        if (is_object($xml) && !empty($xml))
        {
            if (array_key_exists($tag_name, self::$protocolsCorrespondance))
            {
                foreach(self::$protocolsCorrespondance[$tag_name] as $tag_replaced)
                {
                    if (isset($xml->{$tag_replaced}))
                    {
                        $found = $xml->{$tag_replaced};
                        break;
                    }
                }
            }
            else
            {
                if (isset($xml->{$tag_name}))
                {
                    $found = $xml->{$tag_name};
                }
            }
        }
        return $found;
    }

    public static function getContent( $xml_item )
    {
        $content = $xml_item->__toString();
        if ($xml_item)
        {
            foreach($xml_item->children() as $i=>$child){
                $content .= $child->asXml();
            }
        }
        return $content;
    }

    public static function getAttribute( $xml_item, $attribute_name )
    {
        foreach($xml_item->attributes() as $attr=>$attr_val)
        {
            if ($attr===$attribute_name) return $attr_val;
        }
        return null;
    }

    public static function getAttributesAsArray( $xml_item )
    {
        $attrs = array();
        foreach($xml_item->attributes() as $attr=>$attr_val)
        {
            $attrs[$attr] = ($attr_val instanceof SimpleXMLElement) ? self::getContent($attr_val) : $attr_val;
        }
        return $attrs;
    }

// -------------------
// Files informations
// -------------------

    public static function getFilename( $filepath )
    {
        return end(explode('/', $filepath));
    }

    public static function getHumanSize( $size=0, $round=3, $dec_delimiter=',' )
    {
        $unite_spec = array('o','Ko','Mo','Go','To');
        $count=0;
        $c = count($unite_spec);
        while($size>=1024 && $count<$c-1){
            $count++;
            $size/=1024;
        }
        if ($round>=0){
            $arr = pow(10,$round);
            $number = round($size*$arr)/$arr;
        } else {
            $number = $size;
        }
        return str_replace('.',$dec_delimiter,$number).' '.$unite_spec[$count];
    }

// -------------------
// Strings management
// -------------------

    public static function encodeStringToId( $str )
    {
        return md5($str);
    }

    public static function getSecuredString( $str, $in_charset=null, $out_charset='UTF-8//TRANSLIT' )
    {
        if (is_null($in_charset)) $in_charset = mb_detect_encoding($str);
        return iconv($in_charset, $out_charset, $str);
    }

}

// Endfile