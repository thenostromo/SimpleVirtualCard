<?php
namespace Entity;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $priceDollar;

    public function __construct()
    {
        $this->id = null;
    }

    /**
     * @param string $id
     * @return string
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $priceDollar
     * @return $this
     */
    public function setPriceDollar(string $priceDollar)
    {
        $this->priceDollar = $priceDollar;
        return $this;
    }

    /**
     * @return string
     */
    public function getPriceDollar()
    {
        return $this->priceDollar;
    }
}
