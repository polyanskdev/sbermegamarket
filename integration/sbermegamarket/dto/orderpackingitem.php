<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\DTO;

use Citfact\SiteCore\Integration\SberMegaMarket\Interfaces\ArrayableInterface;

class OrderPackingItem implements ArrayableInterface
{
    private int $itemIndex;
    private int $quantity;

    /**
     * OrderPackingItem constructor.
     * @param int $itemIndex
     */
    public function __construct(int $itemIndex)
    {
        $this->itemIndex = $itemIndex;
        $this->quantity = 1;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'itemIndex' => $this->itemIndex,
            'quantity' => $this->quantity,
        ];
    }
}
