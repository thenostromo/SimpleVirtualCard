<?php
namespace Repository;

use DTO\OrderModel;
use Entity\Order;
use Maker\EntityMaker;
use Provider\OrderProvider;

class OrderRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * ProductRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param OrderModel $orderModel
     * @return bool
     */
    public function makeOrder(OrderModel $orderModel): bool
    {
        $stm = $this->connection->prepare("INSERT INTO orders (user_id, transport_type, status, is_formed) VALUES (:userId, :transportType, :status, :isFormed)");
        $stm->bindValue(":userId", $orderModel->userId);
        $stm->bindValue(":transportType", $orderModel->transportType);
        $stm->bindValue(":status", $orderModel->status);
        $stm->bindValue(":isFormed", OrderProvider::ORDER_IS_NOT_FORMED);
        return $stm->execute();
    }

    /**
     * @param int $userId
     * @return Order|null
     */
    public function getLastOrderByUser(int $userId): ?Order
    {
        $stm = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :userId ORDER BY id DESC LIMIT 1");
        $stm->bindValue(":userId", $userId);
        $stm->execute();

        return EntityMaker::makeOrderFromArray($stm->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @param int $userId
     * @return Order[]
     */
    public function getOrderList(int $userId): array
    {
        $stm = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :userId AND is_formed = :isFormed ORDER BY id DESC");
        $stm->bindValue(":userId", $userId);
        $stm->bindValue(":isFormed", OrderProvider::ORDER_IS_FORMED);
        $stm->execute();

        return EntityMaker::makeOrderListFromArray($stm->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function setOrderIsFormed(Order $order): bool
    {
        $stm = $this->connection->prepare("UPDATE orders SET is_formed = :isFormed WHERE id = :orderId");
        $stm->bindValue(":isFormed", OrderProvider::ORDER_IS_FORMED);
        $stm->bindValue(":orderId", $order->getId());
        return $stm->execute();
    }
}
