<?php

namespace GildedRose\ItemUpdaters;

use GildedRose\ItemUpdater;

class SulfurasUpdater implements ItemUpdater
{
    public function update(\GildedRose\Item $item): void {
        // Item behavior
        $item->quality = 80;
    }
}