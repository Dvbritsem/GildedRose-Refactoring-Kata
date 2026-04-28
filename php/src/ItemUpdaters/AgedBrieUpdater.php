<?php

namespace GildedRose\ItemUpdaters;

use GildedRose\ItemUpdater;

class AgedBrieUpdater implements ItemUpdater
{
    public function update(\GildedRose\Item $item): void {
        // Item behavior
        $item->quality++;

        // Quality rules
        if ($item->quality < 0) $item->quality = 0;
        elseif ($item->quality > 50) $item->quality = 50;

        $item->sellIn--;
    }
}