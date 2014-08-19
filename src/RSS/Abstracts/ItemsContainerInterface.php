<?php

namespace RSS\Abstracts;

/**
 * Interface for object containing RSS items
 */
interface ItemsContainerInterface
{
    public function __toString();
    public function getTagItem($tag_name);
}

// Endfile