<?php
namespace DTO;

class CartItemPriceModel
{
    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $productId;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var string
     */
    public $pricePerUnit;
}
