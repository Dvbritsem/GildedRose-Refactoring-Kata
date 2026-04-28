<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    // Normal items without special rules -> -1 sellIn, -1 quality
    public function testSimpleItem(): void
    {
        // Create items to test
        $items = [new Item('foo', 5, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        $this->assertSame(4, $items[0]->sellIn);
        $this->assertSame(9, $items[0]->quality);
    }

    // Aged Brie -> -1 sellIn, +1 quality
    public function testAgedBrie(): void
    {
        // Create items to test
        $items = [new Item('Aged Brie', 5, 5)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        $this->assertSame(4, $items[0]->sellIn);
        $this->assertSame(6, $items[0]->quality);
    }

    // Sulfuras -> No changes
    public function testSulfuras(): void
    {
        // Create items to test
        $items = [new Item('Sulfuras, Hand of Ragnaros', 0, 80)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        $this->assertSame(0, $items[0]->sellIn);
        $this->assertSame(80, $items[0]->quality);
    }

    // Backstage passes -> -1 sellIn
    public function testBackstagePasses(): void
    {
        // Create items to test
        $items = [
            new Item('Backstage passes to a TAFKAL80ETC concert', 3, 10),
            new Item('Backstage passes to a TAFKAL80ETC concert', 8, 10),
            new Item('Backstage passes to a TAFKAL80ETC concert', 12, 10),
            new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        // sellIn <= 5
        $this->assertSame(2, $items[0]->sellIn);
        $this->assertSame(13, $items[0]->quality);
        // sellIn <= 10
        $this->assertSame(7, $items[1]->sellIn);
        $this->assertSame(12, $items[1]->quality);
        // sellIn > 10
        $this->assertSame(11, $items[2]->sellIn);
        $this->assertSame(11, $items[2]->quality);
        // sellIn <= 0
        $this->assertSame(-1, $items[3]->sellIn);
        $this->assertSame(0, $items[3]->quality);
    }

    // Conjured -> -1 sellIn, -2 quality
    public function testConjured(): void
    {
        // Create items to test
        $items = [new Item('Conjured Mana Cake', 3, 6)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        $this->assertSame(2, $items[0]->sellIn);
        $this->assertSame(4, $items[0]->quality);
    }

    // SellIn -> if sellIn is negative -2x quality
    public function testSellInRules(): void
    {
        // Create items to test
        $items = [
            new Item('foo', -1, 10),
            new Item('Aged Brie', -1, 10),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        $this->assertSame(-2, $items[0]->sellIn);
        $this->assertSame(8, $items[0]->quality);
        $this->assertSame(-2, $items[1]->sellIn);
        $this->assertSame(11, $items[1]->quality);
    }

    // Quality is never negative and never more than 50
    public function testQualityRules(): void
    {
        // Create items to test
        $items = [
            new Item('foo', 10, 0),
            new Item('Aged Brie', 10, 50),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // Check results
        // Not less than 0
        $this->assertSame(9, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
        // Not more than 50
        $this->assertSame(9, $items[1]->sellIn);
        $this->assertSame(50, $items[1]->quality);
    }
}
