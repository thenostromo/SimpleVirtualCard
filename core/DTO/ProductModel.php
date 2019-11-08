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
    public $price;

    public function __construct()
    {
        $this->id = null;
        $this->name = null;
        $this->price = null;
    }
}
