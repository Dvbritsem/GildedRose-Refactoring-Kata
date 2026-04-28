<?php

namespace GildedRose\ItemUpdaters;

use GildedRose\ItemUpdater;

class SimpleItemUpdater implements ItemUpdater
{
    public function update(\GildedRose\Item $item): void {
        $item->sellIn--;

        // Item behavior
        if ($item->sellIn < 0) $item->quality = $item->quality - 2;
        else $item->quality--;

        // Quality rules
        if ($item->quality < 0) $item->quality = 0;
        elseif ($item->quality > 50) $item->quality = 50;
    }
}