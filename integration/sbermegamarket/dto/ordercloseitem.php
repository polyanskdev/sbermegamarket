<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket\DTO;

use Citfact\SiteCore\Integration\SberMegaMarket\Interfaces\ArrayableInterface;

class OrderCloseItem implements ArrayableInterface
{
    private int $itemIndex;
    private bool $handoverResult;
    private ?string $reasonType;
    private ?string $reasonComment;

    /**
     * OrderCloseItem constructor.
     * @param int $itemIndex
     * @param bool $handoverResult
     * @param string|null $reasonType
     * @param string|null $reasonComment
     */
    public function __construct(
        int $itemIndex,
        bool $handoverResult,
        ?string $reasonType = null,
        ?string $reasonComment = null
    )
    {
        $this->itemIndex = $itemIndex;
        $this->handoverResult = $handoverResult;
        $this->reasonType = $reasonType;
        $this->reasonComment = $reasonComment;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'itemIndex' => $this->itemIndex,
            'handoverResult' => $this->handoverResult,
            'reason' => [
                'type' => $this->reasonType,
                'comment' => $this->reasonComment,
            ]
        ];
    }
}
