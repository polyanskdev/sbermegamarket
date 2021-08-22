<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\Requests;

use Citfact\SiteCore\Integration\SberMegaMarket\DTO\OrderPackingItem;
use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\ClientException;

class OrderPacking extends BaseRequest
{
    private ?string $orderCode;

    /**
     * OrderPacking constructor.
     * @param int|null $shipmentId
     * @param string|null $orderCode
     */
    public function __construct(?int $shipmentId = null, ?string $orderCode = null)
    {
        parent::__construct();

        $shipmentId ? $this->setShipmentId($shipmentId) : null;
        $orderCode ? $this->setOrderCode($orderCode) : null;
    }

    /**
     * @param string $orderCode
     * @return $this
     */
    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    /**
     * @param int $itemIndex
     * @return $this
     */
    public function addItem(int $itemIndex): self
    {
        $item = new OrderPackingItem($itemIndex);
        $this->pushItem($item);

        return $this;
    }

    /**
     * @throws ClientException
     */
    public function send(): void
    {
        $this->client->orderPacking($this->shipmentId, $this->orderCode, $this->itemCollection);
    }
}
