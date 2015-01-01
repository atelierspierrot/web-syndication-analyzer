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

namespace WebSyndication;

use \DateTime;
use \Locale;
use \SimpleXMLElement;

use \WebSyndication\Helper;
use \WebSyndication\Abstracts\XMLDataObject;
use \WebSyndication\Abstracts\ItemInterface;
use \WebSyndication\Abstracts\ParserInterface;
use \WebSyndication\Abstracts\ItemsContainerInterface;

class Item
    extends XMLDataObject
    implements ItemInterface, ParserInterface, ItemsContainerInterface
{

    public $content = null;
    public $isEmpty = false;
    public $type;
    public $id;

    protected $xml_value;
    protected $name;
    protected $attributes = array();
    protected $settings = array();

    public function __construct($type, $tag_value, $tag_name, $tag_settings = array())
    {
        $this
            ->setType( $type )
            ->setXmlValue( $tag_value instanceOf SimpleXMLElement ? Helper::getContent( $tag_value ) : $tag_value )
            ->setName( $tag_name );

        if ($tag_value instanceOf SimpleXMLElement) {
            $this->setXml( $tag_value );
        }
        if (!is_null($tag_settings)) {
            $this->setSettings( $tag_settings );
        }
        $this->init();
        if (false===$this->isEmpty) {
            $this->parse();
        }
    }
    
    protected function init()
    {
        if (empty($this->xml_value) && $this->type!=='tag') {
            $this->isEmpty = true;
        }
    }

// -------------------
// Getters / Setters / Checkers
// -------------------

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setXmlValue($value)
    {
        $this->xml_value = $value;
        return $this;
    }

    public function getXmlValue()
    {
        return $this->xml_value;
    }

    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function hasSetting($setting_name)
    {
        return (bool) in_array($setting_name, $this->settings);
    }

    public function getSetting($setting_name, $default = null)
    {
        return array_key_exists($setting_name, $this->settings) ? $this->settings[$setting_name] : $default;
    }

    public function exists()
    {
        return false===$this->isEmpty;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function hasAttribute($attribute_name)
    {
        return (bool) array_key_exists($attribute_name, $this->attributes) && !empty($this->attributes[$attribute_name]);
    }

    public function getAttribute($attribute_name, $default = null)
    {
        return array_key_exists($attribute_name, $this->attributes) ? $this->attributes[$attribute_name] : $default;
    }

// -------------------
// Syndication Parser Interface
// -------------------

    public function parse()
    {
        if (is_object($this->xml)) {
            $this->attributes = Helper::getAttributesAsArray($this->getXml());
        }

        switch($this->type) {
            case 'datetime':
                $this->content = new DateTime( $this->xml_value );
                break;
            case 'time':
                $this->content = new DateTime;
                if (true===$this->getSetting('isHours'))
                    $this->content->setTime( $this->xml_value, 0 );
                elseif (true===$this->getSetting('isMinutes'))
                    $this->content->setTime( 0, $this->xml_value );
                elseif (true===$this->getSetting('isSeconds'))
                    $this->content->setTime( 0, 0, $this->xml_value );
                break;
            case 'text':
                $this->content = strip_tags($this->xml_value);
                break;
            case 'lang':
                $this->content = Locale::getDisplayLanguage( $this->xml_value );
                break;
            case 'int': case 'integer':
                $this->content = (int) $this->xml_value;
                break;
            case 'bool': case 'boolean':
                $this->content = (bool) $this->xml_value;
                break;
            case 'list':
                $this->content = array();
                $type = isset($this->settings['listitem_type']) ? $this->settings['listitem_type'] : 'string';
                foreach($this->xml_value as $_value) {
                    $this->content[] = new Item( $type, $_value, $this->name, $this->settings );
                }
                break;
            default:
                $this->content = $this->xml_value;
                break;
        }
    }

// -------------------
// Syndication ItemsContainer Interface
// -------------------

    public function __toString()
    {
        return $this->exists() ? $this->content : '';
    }
    
    public function getTagItem($tag_name)
    {
        return Helper::findTagByCommonName( $this, $tag_name );
    }

// -------------------
// Syndication Item Interface
// -------------------

    public function getHtml()
    {
        if (!$this->exists()) return '';
        switch($this->type) {
            case 'datetime':
                $html = '<abbr title="'.$this->content->format('c').'">'
                    .(class_exists('WebSyndication\Helper') ?
                        \WebSyndication\Helper::getLocalizedDateString($this->content) : $this->content->format('D j m Y H:i:s')
                    ).'</abbr>';
                break;
            case 'time':
                $html = $this->content->format('H:i:s');
                break;
            case 'email':
                $html = '<a href="mailto:'.$this->content.'" title="Contact this email">'.$this->content.'</a>';
                break;
            case 'url':
                $html = '<a href="'.$this->content.'" title="See online">'.$this->content.'</a>';
                break;
            case 'text':
                $html = $this->xml_value;
                break;
            case 'lang':
                $html = '<abbr title="ISO : '.$this->xml_value.'">'.$this->content.'</abbr>';
                break;
            case 'list':
                $html = '';
                foreach($this->content as $_ctt)
                {
                    $html .= (strlen($html) ? ', ' : '').$_ctt->content;
                }
                break;
            default:
                $html = $this->content;
                break;
        }
        return $html;
    }

}

// Endfile