<?php
namespace DTO;

class ProductModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $priceDollar;

    public function __construct()
    {
        $this->id = null;
        $this->name = null;
        $this->priceDollar = null;
    }
}
