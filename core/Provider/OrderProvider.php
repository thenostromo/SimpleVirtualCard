<?php
namespace Provider;

class OrderProvider
{
    const ORDER_IS_NOT_FORMED = 0;
    const ORDER_IS_FORMED = 1;

    const ORDER_STATUS_IS_BEING_PROCESSED = 0;
    const ORDER_STATUS_COMPLETED = 1;
    const ORDER_STATUS_DELIVERED = 2;

    const TRANSPORT_TYPE_PICK_UP = 0;
    const TRANSPORT_TYPE_UPS = 1;

    /**
     * @return array
     */
    public static function getOrderStatusChoice()
    {
        return [
            self::ORDER_STATUS_IS_BEING_PROCESSED => "Is being processed",
            self::ORDER_STATUS_COMPLETED => "Completed",
            self::ORDER_STATUS_DELIVERED => "Delivered"
        ];
    }

    /**
     * @return array
     */
    public static function getTransportTypeChoice()
    {
        return [
            self::TRANSPORT_TYPE_PICK_UP => "Pick up",
            self::TRANSPORT_TYPE_UPS => "UPS"
        ];
    }

    /**
     * @return array
     */
    public static function getTransportTypePrice()
    {
        return [
            self::TRANSPORT_TYPE_PICK_UP => "0.00",
            self::TRANSPORT_TYPE_UPS => "5.00"
        ];
    }
}
