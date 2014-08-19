<?php


class FeedsCollection_Model
    extends CRUD_Model_Base
    implements CRUD_Model_Interface
{

// --------------------
// Construct / Destruct / Clone
// --------------------

    protected function init( array $user_options=array() )
    {
        $this->entity = array();
        $this->options = array(
            'feeds_list_filename' => 'feeds_list',
        );
        $this->extendOptions($user_options);
        $this->options['model_filecache'] = $this->getOption('feeds_list_filename');
        return $this;
    }

    protected function initWhenLoaded()
    {
        $entities = array();
        if (!empty($this->entity))
        {
            foreach($this->getEntity() as $i=>$entity)
            {
                if (!empty($entity) && !is_null($entity))
                {
                    $entities[$i] = $entity;
                }
            }
            uasort($entities, array($this, 'compareToSort'));
            $this->entity = $entities;
        }
        return $this;
    }
    
// --------------------
// Getters / Setters
// --------------------

    public static function compareToSort( $a, $b )
    {
        if (!isset($a->sort)) $a->sort = 10000;
        if (!isset($b->sort)) $b->sort = 10000;
        if ($a->sort===$b->sort) { return 0; }
        return ($a->sort<$b->sort) ? -1 : 1;
    }

    public function getEntityAsArray()
    {
        $entities = array();
        if (!empty($this->entity))
        {
            foreach($this->getEntity() as $i=>$entity)
            {
                $entities[ (isset($entity->name) ? $entity->name : $i) ] = $entity->url;
            }
        }
        return $entities;
    }

    public function entityExists( $url )
    {
        foreach($this->entity as $id=>$data)
        {
            if ($data->url===$url) return true;
        }
        return false;
    }

    public function buildNewEntity( $data )
    {
        if (isset($data['url']))
        {
            $obj = new StdClass;
            $obj->url = $data['url'];
            $obj->name = isset($data['name']) ? $data['name'] : (
                false!==($ttl = APP_Helper::getUrlTitle($obj->url)) ? $ttl : null
            );
            $obj->id = isset($data['id']) ? $data['id'] : md5($obj->url);
            return $obj;
        }
        else
        {
            throw new Exception(
                sprintf('Missing the mandatory field "url" while trying to add entity to "%s" model!', get_class($this))
            );
        }
    }

// --------------------
// CRUD interface
// --------------------

    public function create( $data )
    {
        $obj = $this->buildNewEntity($data);
        if (!empty($obj))
        {
            $this->entity[$obj->id] = $obj;
            $this->_isModified = true;
            return $this->save();
        }
        return false;
    }
    
    public function read( $id )
    {
        if (!empty($this->entity))
        {
            foreach($this->entity as $i=>$data)
            {
                if ($i===$id)
                {
                    return $data;
                }
            }
        }
        return false;
    }
    
    public function update( $id, $data )
    {
        $obj = $this->buildNewEntity($data);
        if (!empty($obj))
        {
            foreach($this->entity as $i=>$data)
            {
                if ($i===$id)
                {
                    $this->entity[$i] = $obj;
                    $this->_isModified = true;
                    return $this->save();
                }
            }
        }
        return false;
    }
    
    public function delete( $url )
    {
        if (!empty($this->entity))
        {
            foreach($this->entity as $i=>$data)
            {
                if ($data->url===$url)
                {
                    $this->entity[$i]=null;
                    $this->_isModified = true;
                    return $this->save();
                }
            }
        }
        return false;
    }
    
    public function reorder( array $list, $by='feed_name' )
    {
        $attr = ($by==='feed_name') ? 'name' : (($by==='feed_url') ? 'url' : null);
        if (!empty($this->entity) && !empty($list) && !empty($attr))
        {
            foreach($this->entity as $id=>$data)
            {
                $_val = $data->{$attr};
                if (in_array($_val, $list))
                {
                    $data->sort = array_search($_val, $list);
                    $this->entity[$id] = $data;
                }
            }
            $this->_isModified = true;
            return $this->save();
        }
        return false;
    }

}

// Endfile