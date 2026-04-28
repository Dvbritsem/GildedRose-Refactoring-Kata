<?php

namespace GildedRose;

interface ItemUpdater
{
    public function update(Item $item): void;
}