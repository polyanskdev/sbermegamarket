<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\Requests;

use DateTime;
use Citfact\SiteCore\Integration\SberMegaMarket\DTO\OrderCloseItem;
use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\ClientException;

class OrderClose  extends BaseRequest
{
    private ?DateTime $closeDate;

    public const TYPE_CANCEL_BY_CUSTOMER = 'CANCEL_BY_CUSTOMER';
    public const TYPE_HANDOVER_IMPOSSIBLE = 'HANDOVER_IMPOSSIBLE';

    /**
     * OrderClose constructor.
     * @param int|null $shipmentId
     * @param DateTime|null $closeDate
     */
    public function __construct(?int $shipmentId = null, ?DateTime $closeDate = null)
    {
        parent::__construct();

        $shipmentId ? $this->setShipmentId($shipmentId) : null;
        $closeDate ? $this->setCloseData($closeDate) : null;
    }

    /**
     * @param DateTime $closeDate
     * @return $this
     */
    public function setCloseData(DateTime $closeDate): self
    {
        $this->closeDate = $closeDate;

        return $this;
    }

    /**
     * @param int $itemIndex
     * @param bool $handoverResult
     * @param string|null $reasonType
     * @param string|null $reasonComment
     * @return $this
     */
    public function addItem(
        int $itemIndex,
        bool $handoverResult,
        ?string $reasonType = null,
        ?string $reasonComment = null
    ): self
    {
        $item = new OrderCloseItem($itemIndex, $handoverResult, $reasonType, $reasonComment);
        $this->pushItem($item);

        return $this;
    }

    /**
     * @throws ClientException
     */
    public function send(): void
    {
        $this->client->orderClose($this->shipmentId, $this->closeDate, $this->itemCollection);
    }
}
