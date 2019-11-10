<?php
namespace Entity;

class OrderItem
{
    /**
     * @var int
     */
    private $orderId;

    /**
     * @var int
     */
    private $productId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param int $orderId
     * @return OrderItem
     */
    public function setOrderId(int $orderId): OrderItem
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $productId
     * @return OrderItem
     */
    public function setProductId(int $productId): OrderItem
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $quantity
     * @return OrderItem
     */
    public function setQuantity(int $quantity): OrderItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
