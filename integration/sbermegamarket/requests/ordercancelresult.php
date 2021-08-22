<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\Requests;

use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\ClientException;
use Citfact\SiteCore\Integration\SberMegaMarket\DTO\OrderCancelResultItem;

class OrderCancelResult extends BaseRequest
{
    /**
     * OrderCancelResult constructor.
     * @param int|null $shipmentId
     */
    public function __construct(?int $shipmentId = null)
    {
        parent::__construct();

        $shipmentId ? $this->setShipmentId($shipmentId) : null;
    }

    /**
     * @param int $itemIndex
     * @param bool $canceled
     * @return $this
     */
    public function addItem(int $itemIndex, bool $canceled = true): self
    {
        $item = new OrderCancelResultItem($itemIndex, $canceled);
        $this->pushItem($item);

        return $this;
    }

    /**
     * @throws ClientException
     */
    public function send(): void
    {
        $this->client->orderCancelResult($this->shipmentId, $this->itemCollection);
    }
}
