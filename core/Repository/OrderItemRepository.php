<?php
namespace Repository;

use DTO\CartItemModel;
use DTO\OrderItemModel;
use DTO\OrderItemPriceModel;
use DTO\OrderModel;
use Entity\CartItem;
use Entity\Order;
use Entity\OrderItem;
use Maker\DTOMaker;
use Maker\EntityMaker;

class OrderItemRepository
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
     * @param OrderItemModel $orderItemModel
     * @return OrderItem|null
     */
    public function getOrderItem(OrderItemModel $orderItemModel): ?OrderItem
    {
        $stm = $this->connection->prepare("SELECT * FROM orders_products WHERE order_id = :orderId AND product_id = :productId");
        $stm->bindValue(":orderId", $orderItemModel->orderId);
        $stm->bindValue(":productId", $orderItemModel->productId);
        $stm->execute();

        return EntityMaker::makeOrderItemFromArray($stm->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @param int $orderId
     * @return OrderItemPriceModel[]
     */
    public function getOrderItemPriceList(int $orderId): array
    {
        $stm = $this->connection->prepare("
            SELECT 
                op.product_id as product_id, 
                op.quantity as quantity,
                p.price as price_per_unit
            FROM orders_products op
            INNER JOIN product p
                ON op.product_id = p.id
            WHERE op.order_id = :orderId");

        $stm->bindValue(":orderId", $orderId);
        $stm->execute();

        return DTOMaker::makeOrderItemPriceModelList($stm->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param OrderItemModel $orderItemModel
     * @return bool
     */
    public function addOrderItem(OrderItemModel $orderItemModel): bool
    {
        $stm = $this->connection->prepare("INSERT INTO orders_products (order_id, product_id, quantity) VALUES (:orderId, :productId, :quantity)");
        $stm->bindValue(":orderId", $orderItemModel->orderId);
        $stm->bindValue(":productId", $orderItemModel->productId);
        $stm->bindValue(":quantity", $orderItemModel->quantity);

        return $stm->execute();
    }
}
