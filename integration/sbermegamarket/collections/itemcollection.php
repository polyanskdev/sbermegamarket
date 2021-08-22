<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\Collections;

use IteratorAggregate;
use ArrayIterator;
use Citfact\SiteCore\Integration\SberMegaMarket\Interfaces\ArrayableInterface;

class ItemCollection implements ArrayableInterface, IteratorAggregate
{
    private array $items = [];

    /**
     * @param ArrayableInterface ...$items
     * @return ItemCollection
     */
    public function add(ArrayableInterface ...$items): self
    {
        foreach ($items as $item) {
            $this->items[] = $item;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->items as $item) {
            /** @var ArrayableInterface $item */
            $result[] = $item->toArray();
        }
        return $result;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
