<?php

namespace Citfact\SiteCore\Integration\SberMegaMarket;

use DateTime;
use Bitrix\Main\Web\Json;
use Citfact\SiteCore\Options;
use Citfact\SiteCore\Tools\WebService\CurlWebService;
use Citfact\SiteCore\Tools\WebService\Loggers\HighloadLogger;
use Citfact\SiteCore\Integration\SberMegaMarket\Collections\ItemCollection;
use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\ClientException;
use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\NotImplementedException;

class SberMegaMarketClient extends CurlWebService
{
    private string $apiToken;

    private const URL = 'https://partner.sbermegamarket.ru/api/market/v1/orderService';
    private const URL_TEST = 'https://partner.goodsteam.tech/api/market/v1/orderService';

    private const METHOD_ORDER_PACKING = '/order/packing';
    private const METHOD_REJECT = '/order/reject';
    private const METHOD_CLOSE = '/order/close';
    private const METHOD_CANCEL_RESULT = '/order/cancelResult';

    /**
     * SberMegaMarketClient constructor.
     */
    public function __construct()
    {
        parent::__construct(new HighloadLogger());
    }

    /**
     * @param string $shipmentId
     * @param string $orderCode
     * @param ItemCollection $items
     * @return array
     * @throws ClientException
     */
    public function orderPacking(string $shipmentId, string $orderCode, ItemCollection $items): array
    {
        $data = [
            'meta' => [],
            'data' => [
                'token' => $this->getApiToken(),
                'shipments' => [
                    [
                        'shipmentId' => $shipmentId,
                        'orderCode' => $orderCode,
                        'items' => $items->toArray()
                    ]
                ]
            ]
        ];

        return $this->sendRequest(self::METHOD_ORDER_PACKING, $data);
    }

    /**
     * @param string $shipmentId
     * @param ItemCollection $items
     * @param string|null $reasonType
     * @param string|null $reasonComment
     * @return array
     * @throws ClientException
     */
    public function orderReject(
        string $shipmentId,
        ItemCollection $items,
        ?string $reasonType,
        ?string $reasonComment
    ): array
    {
        $data = [
            'meta' => [],
            'data' => [
                'token' => $this->getApiToken(),
                'shipments' => [
                    [
                        'shipmentId' => $shipmentId,
                        'items' => $items->toArray()
                    ]
                ],
                'reason' => [
                    'type' => $reasonType ?: null,
                    'comment' => $reasonComment ?: null,
                ],
            ]
        ];

        return $this->sendRequest(self::METHOD_REJECT, $data);
    }

    /**
     * @param string $shipmentId
     * @param DateTime $closeDate
     * @param ItemCollection $items
     * @return array
     * @throws ClientException
     */
    public function orderClose(string $shipmentId, DateTime $closeDate, ItemCollection $items): array
    {
        $data = [
            'meta' => [],
            'data' => [
                'token' => $this->getApiToken(),
                'closeDate' => $closeDate->format(DateTime::ATOM),
                'shipments' => [
                    [
                        'shipmentId' => $shipmentId,
                        'items' => $items->toArray()
                    ]
                ]
            ]
        ];

        return $this->sendRequest(self::METHOD_CLOSE, $data);
    }

    /**
     * @param string $shipmentId
     * @param ItemCollection $items
     * @return array
     * @throws ClientException
     */
    public function orderCancelResult(string $shipmentId, ItemCollection $items): array
    {
        $data = [
            'meta' => [],
            'data' => [
                'token' => $this->getApiToken(),
                'shipments' => [
                    [
                        'shipmentId' => $shipmentId,
                        'items' => $items->toArray()
                    ]
                ]
            ]
        ];

        return $this->sendRequest(self::METHOD_CANCEL_RESULT, $data);
    }

    /**
     * @throws NotImplementedException
     */
    public function orderSearch(): void
    {
        throw new NotImplementedException('Метод order/search не реализован');
    }

    /**
     * @throws NotImplementedException
     */
    public function orderGet(): void
    {
        throw new NotImplementedException('Метод order/get не реализован');
    }

    /**
     * @return string
     * @throws ClientException
     */
    private function getApiToken(): string
    {
        $token = $this->apiToken ?: $this->apiToken = Options::getValue('SBER_MARKET', ['API', 'TOKEN']);
        if (!$token) {
            throw new ClientException('Не указан API токен');
        }

        return $token;
    }

    /**
     * @param string|null $methodUrl
     * @return string
     */
    private function getUrl(?string $methodUrl = null): string
    {
        $isTestServer = Options::getValue('SBER_MARKET', ['API', 'TEST_SERVER']);
        $url = $isTestServer ? static::URL_TEST : static::URL;

        return $methodUrl ? $url . $methodUrl : $url;
    }

    /**
     * @param string $method
     * @param array $data
     * @return array
     * @throws ClientException
     */
    private function sendRequest(string $method, array $data): array
    {
        $this->setHeader('Content-Type', 'application/json');
        $requestUrl = $this->getUrl($method);
        $data = Json::encode($data);

        $response = $this->request($requestUrl, $data, static::METHOD_POST);
        $responseStatus = $this->getStatusCode();

        if (!$response || $responseStatus !== 200) {
            throw new ClientException('Запрос не обработан. Код ответа сервера: ' . $responseStatus);
        }

        $result = Json::decode($response);
        if (!$result['success']) {
            $messages = [];
            foreach ($result['error'] as $error) {
                $message = $error['errorText'] ?: $error['message'] ?: 'Неизвестная ошибка';
                $message .= $error['description'] ? ': ' . $error['description'] : '';
                $messages[] = $message;
            }

            throw new ClientException(implode('; ', $messages));
        }

        return $result;
    }
}
