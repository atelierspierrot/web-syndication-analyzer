<?php

namespace RSS;

use \SimpleXMLElement;

/**
 * Helper class for RSS library
 */
class Helper
{

// -------------------
// Static configuration
// -------------------

    protected static $_config = array(
        'resources_dir'                 => 'Resources/',
        'specifications_dir'            => 'Resources/specifications/',
        'views_dir'                     => 'Resources/views/',
        'templates'                     => array(
            'breadcrumb_tag_template'   => 'tag/tag-breadcrumb.htm',
            'category_tag_template'     => 'tag/tag-category.htm',
            'content_tag_template'      => 'tag/tag-content.htm',
            'date_tag_template'         => 'tag/tag-date.htm',
            'date_tag_widget_template'  => 'tag/tag-date-widget.htm',
            'image_tag_template'        => 'tag/tag-image.htm',
            'image_tag_widget_template' => 'tag/tag-image-widget.htm',
            'media_tag_template'        => 'tag/tag-media.htm',
            'person_tag_template'       => 'tag/tag-person.htm',
            'person_tag_widget_template'=> 'tag/tag-person-widget.htm',
        )
    );

    public static function getOption($name, $default = null)
    {
        return isset(self::$_config[$name]) ? self::$_config[$name] : $default;
    }

    public static function getTemplate($name)
    {
        $templates = self::getOption('templates', array());
        $views_dir = self::getOption('views_dir');
        return isset($templates[$name]) ? (
            file_exists(__DIR__.'/'.$views_dir.$templates[$name]) ? __DIR__.'/'.$views_dir.$templates[$name] : $templates[$name]
        ) : null;
    }

// -------------------
// Feeds specifications
// -------------------

    public static $specifications=array();

    public static function getSpecifications( $protocol, $version )
    {
        $specs_name = strtolower($protocol).( !empty($version) ? '-'.$version : '' );
        $specs_dir = self::getOption('specifications_dir');
        if (!isset(self::$specifications[$specs_name])) {
            $specs_file = __DIR__.'/'.$specs_dir.$specs_name.'.ini';

            $specs = @parse_ini_file($specs_file, true);
            if (!$specs) {
                throw new \RuntimeException(
                    sprintf('Specifications file for protocol "%s" not found or is not a valid INI file! (searched in "%s"', $specs_name, $specs_file)
                );
            }
            if (isset($specs['common'])) {
                foreach($specs as $tag=>$data) {
                    if ($tag!=='common') {
                        $specs[$tag] = array_merge($specs['common'], $specs[$tag]);
                    }
                }
            }
            self::$specifications[$specs_name] = $specs;
        }
        return self::$specifications[$specs_name];
    }

// -------------------
// Feed information
// -------------------

    public static function readProtocol( SimpleXMLElement $xml )
    {
        return $xml->getName();
    }
    
    public static function readVersion( SimpleXMLElement $xml )
    {
        foreach($xml->attributes() as $attr=>$attr_val) {
            if ($attr==='version') return $attr_val;
        }
        return null;
    }
    
    public static function readNamespaces( SimpleXMLElement $xml, $recursive=true )
    {
        return $xml->getNamespaces($recursive);
    }
    
// -------------------
// XMLObject information
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
        if (is_object($xml) && !empty($xml)) {
            if (array_key_exists($tag_name, self::$protocolsCorrespondance)) {
                foreach(self::$protocolsCorrespondance[$tag_name] as $tag_replaced) {
                    if (isset($xml->{$tag_replaced})) {
                        $found = $xml->{$tag_replaced};
                        break;
                    }
                }
            } else {
                if (isset($xml->{$tag_name})) {
                    $found = $xml->{$tag_name};
                }
            }
        }
        return $found;
    }

    public static function getContent( $xml_item )
    {
        $content = $xml_item->__toString();
        if ($xml_item) {
            foreach($xml_item->children() as $i=>$child){
                $content .= $child->asXml();
            }
        }
        return $content;
    }

    public static function getAttribute( $xml_item, $attribute_name )
    {
        foreach($xml_item->attributes() as $attr=>$attr_val) {
            if ($attr===$attribute_name) return $attr_val;
        }
        return null;
    }

    public static function getAttributesAsArray( $xml_item )
    {
        $attrs = array();
        foreach($xml_item->attributes() as $attr=>$attr_val) {
            $attrs[$attr] = ($attr_val instanceof SimpleXMLElement) ? self::getContent($attr_val) : $attr_val;
        }
        return $attrs;
    }

// -------------------
// Files information
// -------------------

    public static function getFilename( $filepath )
    {
        $explode_filepath = explode('/', $filepath);
        return \Library\Helper\File::getHumanReadableFilename(end($explode_filepath));
    }

    public static function isImage($name)
    {
        $extension = \Library\Helper\File::getExtension($name);
        return in_array(strtolower($extension), array('png', 'jpg', 'jpeg', 'gif'));
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

// -------------------
// View rendering
// -------------------

    public static function renderView($view_file, array $options = array())
    {
        if ($view_file && @file_exists($view_file)) {
            if (!empty($options)) {
                extract($options, EXTR_OVERWRITE);
            }
            ob_start();
            include $view_file;
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            throw new \RuntimeException(
                sprintf('View "%s" can\'t be found!', $view_file)
            );
        }
        return $output;
    }

}

// Endfile