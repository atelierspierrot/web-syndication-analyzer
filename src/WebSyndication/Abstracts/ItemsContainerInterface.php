<?php

namespace WebSyndication\Abstracts;

/**
 * Interface for object containing syndication items
 */
interface ItemsContainerInterface
{
    public function __toString();
    public function getTagItem($tag_name);
}

// Endfile