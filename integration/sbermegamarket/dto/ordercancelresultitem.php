<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\DTO;

use Citfact\SiteCore\Integration\SberMegaMarket\Interfaces\ArrayableInterface;

class OrderCancelResultItem implements ArrayableInterface
{
    private int $itemIndex;
    private bool $canceled;

    /**
     * OrderCancelResultItem constructor.
     * @param int $itemIndex
     * @param bool $canceled
     */
    public function __construct(int $itemIndex, bool $canceled = true)
    {
        $this->itemIndex = $itemIndex;
        $this->canceled = $canceled;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'itemIndex' => $this->itemIndex,
            'canceled' => $this->canceled,
        ];
    }
}
