<?php
namespace Repository;

use DTO\CartItemModel;
use Entity\Cart;
use Entity\CartItem;
use Maker\EntityMaker;

class CartItemRepository
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
     * @param CartItemModel $cartItemModel
     * @return CartItem
     */
    public function getCartItem(CartItemModel $cartItemModel)
    {
        $stm = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :userId AND product_id = :productId");
        $stm->bindValue(":userId", $cartItemModel->userId);
        $stm->bindValue(":productId", $cartItemModel->productId);
        $stm->execute();

        return EntityMaker::makeCartItemFromArray($stm->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @param CartItemModel $cartItemModel
     * @return bool
     */
    public function addCartItem(CartItemModel $cartItemModel)
    {
        $stm = $this->connection->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:userId, :productId, :quantity)");
        $stm->bindValue(":userId", $cartItemModel->userId);
        $stm->bindValue(":productId", $cartItemModel->productId);
        $stm->bindValue(":quantity", $cartItemModel->quantity);
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param CartItem $cartItem
     * @return bool
     */
    public function updateCartItem(CartItem $cartItem)
    {
        $stm = $this->connection->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :userId AND product_id = :productId");
        $stm->bindValue(":userId", $cartItem->getUserId());
        $stm->bindValue(":productId", $cartItem->getProductId());
        $stm->bindValue(":quantity", $cartItem->getQuantity());
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }


    /**
     * @param int $userId
     * @return Cart[]
     */
    public function getUserCart(int $userId)
    {
        $stm = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :userId");
        $stm->bindValue(":userId", $userId);
        $stm->execute();

        return EntityMaker::makeCartListFromArray($stm->fetchAll(\PDO::FETCH_ASSOC));
    }
}
