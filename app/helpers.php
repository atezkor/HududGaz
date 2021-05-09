<?php
    function menu_items($items) {
        foreach ($items as $item) {
            $item->href = $item->link(true);
            $item->title = __($item->title);

            if (count($item->children) < 0)
                break;

            foreach ($item->children as $child){
                $child->href = $child->link(true);
                $child->title = __($child->title);
            }
        }
        return $items;
    }
