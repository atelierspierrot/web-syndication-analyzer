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

use \Patterns\Commons\Collection;

use \WebSyndication\Feed;

/**
 * The collection handler for items
 */
class ItemsCollection
    extends Collection
{

    /**
     * Construction of a collection
     *
     * @param   array|string   $items_collection    The array of the collection content (optional)
     * @throws  \InvalidArgumentException if the collection argument is not an array
     */
    public function __construct($items_collection = array())
    {
        if (empty($items_collection)) {
            throw new \InvalidArgumentException(
                sprintf('Creation of a "%s" instance with no items collection is not allowed!', __CLASS__)
            );
        }
        if (!is_array($items_collection)) $items_collection = array( $items_collection );
        parent::__construct( $items_collection );
    }

    public function read()
    {
        foreach ($this->getCollection() as $item) {
            $item->read();
        }
    }

// -------------------
// Collection manager
// -------------------

    public function getItemsCount()
    {
        return $this->count();
    }

    public function getItems($limit = null, $offset = 0)
    {
        $collection = $this->getCollection();
        usort($collection, function($a,$b){
            $a_date = $a->getTagItem('updated_date');
            $b_date = $b->getTagItem('updated_date');
            return (isset($a_date) && isset($b_date) && $a_date<$b_date);
        });
        return array_slice($collection, $offset, $limit);
    }

    public function getItemsCategories($limit = null, $offset = 0)
    {
        $categories = array();
        foreach ($this->getItems($limit, $offset) as $item) {
            $_cats = $item->getTagItem('category');
            if ($_cats && is_array($_cats->content)) {
                foreach($_cats->content as $j=>$_cat) {
                    $cat_label = ($_cat->hasAttribute('term') ? $_cat->getAttribute('term') : $_cat->content);
                    if (!in_array($cat_label, $categories)) {
                        $categories[] = $cat_label;
                    }
                }
            }
        }
        natsort($categories);
        return $categories;
    }

    public function getItemsCollectionByCategorie($category, $limit = null, $offset = 0)
    {
        $collection = array();
        foreach ($this->getItems() as $item) {
            $_cats = $item->getTagItem('category');
            if ($_cats && is_array($_cats->content)) {
                foreach($_cats->content as $j=>$_cat) {
                    $cat_label = ($_cat->hasAttribute('term') ? $_cat->getAttribute('term') : $_cat->content);
                    if ($cat_label==$category) {
                        $collection[] = $item;
                        continue 2;
                    }
                }
            }
        }
        return array_slice($collection, $offset, $limit);
    }

}

// Endfile