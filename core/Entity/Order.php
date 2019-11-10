<?php
namespace Entity;

class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $transportType;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $isFormed;

    public function __construct()
    {
        $this->id = null;
    }

    /**
     * @param string $id
     * @return Order
     */
    public function setId(string $id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $userId
     * @return Order
     */
    public function setUserId(int $userId): Order
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $transportType
     * @return Order
     */
    public function setTransportType(int $transportType): Order
    {
        $this->transportType = $transportType;
        return $this;
    }

    /**
     * @return int
     */
    public function getTransportType(): int
    {
        return $this->transportType;
    }

    /**
     * @param int $status
     * @return Order
     */
    public function setStatus(int $status): Order
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $isFormed
     * @return Order
     */
    public function setIsFormed(int $isFormed): Order
    {
        $this->isFormed = $isFormed;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsFormed(): int
    {
        return $this->isFormed;
    }
}
