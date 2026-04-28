<?php

namespace GildedRose\ItemUpdaters;

use GildedRose\ItemUpdater;

class ConjuredUpdater implements ItemUpdater
{
    public function update(\GildedRose\Item $item): void {
        // Item behavior
        if ($item->sellIn < 0) $item->quality = $item->quality - 4;
        else $item->quality = $item->quality - 2;

        // Quality rules
        if ($item->quality < 0) $item->quality = 0;
        elseif ($item->quality > 50) $item->quality = 50;

        $item->sellIn--;
    }
}