<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\Requests;

use Citfact\SiteCore\Integration\SberMegaMarket\DTO\OrderRejectItem;
use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\ClientException;

class OrderReject extends BaseRequest
{
    private ?string $reasonType;
    private ?string $reasonComment;

    public const TYPE_OUT_OF_STOCK = 'OUT_OF_STOCK';
    public const TYPE_NOT_ACCEPTABLE = 'NOT_ACCEPTABLE';

    /**
     * OrderReject constructor.
     * @param int|null $shipmentId
     * @param string|null $reasonType
     * @param string|null $reasonComment
     */
    public function __construct(?int $shipmentId = null, ?string $reasonType = null, ?string $reasonComment = null)
    {
        parent::__construct();

        $shipmentId ? $this->setShipmentId($shipmentId) : null;
        $reasonType ? $this->setReasonType($reasonType) : null;
        $reasonComment ? $this->setReasonComment($reasonComment) : null;
    }

    /**
     * @param string $reasonType
     * @return $this
     */
    public function setReasonType(string $reasonType): self
    {
        $this->reasonType = $reasonType;

        return $this;
    }

    /**
     * @param string $reasonComment
     * @return $this
     */
    public function setReasonComment(string $reasonComment): self
    {
        $this->reasonComment = $reasonComment;

        return $this;
    }

    /**
     * @param int $itemIndex
     * @param string $offerId
     * @return $this
     */
    public function addItem(int $itemIndex, string $offerId): self
    {
        $item = new OrderRejectItem($itemIndex, $offerId);
        $this->pushItem($item);

        return $this;
    }

    /**
     * @throws ClientException
     */
    public function send(): void
    {
        $this->client->orderReject(
            $this->shipmentId,
            $this->itemCollection,
            $this->reasonType,
            $this->reasonComment
        );
    }
}
