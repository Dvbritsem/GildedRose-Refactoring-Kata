<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\ItemUpdaters\AgedBrieUpdater;
use GildedRose\ItemUpdaters\BackstagePassesUpdater;
use GildedRose\ItemUpdaters\ConjuredUpdater;
use GildedRose\ItemUpdaters\SimpleItemUpdater;
use GildedRose\ItemUpdaters\SulfurasUpdater;

final class GildedRose
{
    private array $updaters;

    public function __construct(private array $items)
    {
        $this->updaters = [
            'Simple Item' => new SimpleItemUpdater(),
            'Aged Brie' => new AgedBrieUpdater(),
            'Backstage Passes' => new BackstagePassesUpdater(),
            'Sulfuras' => new SulfurasUpdater(),
            'Conjured' => new ConjuredUpdater(),
        ];
    }

    private function getUpdater(Item $item): ItemUpdater
    {
        foreach ($this->updaters as $key => $updater) {
            if (str_contains($item->name, $key)) return $updater;
        }

        return $this->updaters['Simple Item'];
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $updater = $this->getUpdater($item);
            $updater->update($item);
        }
    }
}
