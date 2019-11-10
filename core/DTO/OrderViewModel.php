<?php
namespace DTO;

class OrderViewModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $transportType;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $totalPrice;
}