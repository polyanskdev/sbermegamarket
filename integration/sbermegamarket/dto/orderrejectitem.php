<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\DTO;

use Citfact\SiteCore\Integration\SberMegaMarket\Interfaces\ArrayableInterface;

class OrderRejectItem implements ArrayableInterface
{
    private int $itemIndex;
    private string $offerId;

    /**
     * OrderRejectItem constructor.
     * @param int $itemIndex
     * @param string $offerId
     */
    public function __construct(int $itemIndex, string $offerId)
    {
        $this->itemIndex = $itemIndex;
        $this->offerId = $offerId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'itemIndex' => $this->itemIndex,
            'offerId' => $this->offerId,
        ];
    }
}
