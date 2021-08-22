<?php

use Citfact\SiteCore\Integration\SberMegaMarket\Requests\OrderCancelResult;
use Citfact\SiteCore\Integration\SberMegaMarket\Requests\OrderClose;
use Citfact\SiteCore\Integration\SberMegaMarket\Requests\OrderPacking;
use Citfact\SiteCore\Integration\SberMegaMarket\Requests\OrderReject;
use Citfact\SiteCore\Integration\SberMegaMarket\Exceptions\ClientException;

try {

    /*
     * Отправка запроса методом order/packing
     */
    $orderPacking = new OrderPacking();
    $orderPacking->setShipmentId(111)
        ->setOrderCode(222)
        ->addItem(1)
        ->addItem(2)
        ->send();

    /*
     * Отправка запроса методом order/reject
     */
    $orderReject = new OrderReject();
    $orderReject->setShipmentId(111)
        ->setReasonType(OrderReject::TYPE_NOT_ACCEPTABLE)
        ->addItem(1, '1000')
        ->addItem(2, '1001')
        ->send();

    /*
     * Отправка запроса методом order/close
     */
    $orderClose = new OrderClose(111, new DateTime());
    $orderClose->addItem(1, false)
        ->addItem(2, false)
        ->send();

    /*
     * Отправка запроса методом order/cancelResult
     */
    $orderCancelResult = new OrderCancelResult(111);
    $orderCancelResult->addItem(1, true)
        ->addItem(1, false)
        ->send();

} catch (ClientException $e) {
    // todo
}
