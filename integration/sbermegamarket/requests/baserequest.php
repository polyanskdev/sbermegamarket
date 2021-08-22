<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\Requests;

use Citfact\SiteCore\Integration\SberMegaMarket\Interfaces\ArrayableInterface;
use Citfact\SiteCore\Integration\SberMegaMarket\Collections\ItemCollection;
use Citfact\SiteCore\Integration\SberMegaMarket\SberMegaMarketClient;

abstract class BaseRequest
{
    protected ?int $shipmentId;
    protected SberMegaMarketClient $client;
    protected ItemCollection $itemCollection;

    /**
     * OrderCancelResult constructor.
     */
    public function __construct()
    {
        $this->client = new SberMegaMarketClient();
        $this->itemCollection = new ItemCollection();
    }

    /**
     * @param int $shipmentId
     * @return $this
     */
    public function setShipmentId(int $shipmentId): self
    {
        $this->shipmentId = $shipmentId;

        return $this;
    }

    /**
     * @param ArrayableInterface $item
     * @return $this
     */
    protected function pushItem(ArrayableInterface $item): self
    {
        $this->itemCollection->add($item);

        return $this;
    }

    abstract public function send(): void;
}
