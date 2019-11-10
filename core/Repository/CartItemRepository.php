<?php
namespace Repository;

use DTO\CartItemModel;
use DTO\CartItemPriceModel;
use DTO\CartItemViewModel;
use Entity\Cart;
use Entity\CartItem;
use Maker\DTOMaker;
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
     * @return CartItem|null
     */
    public function getCartItem(CartItemModel $cartItemModel): ?CartItem
    {
        $stm = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :userId AND product_id = :productId");
        $stm->bindValue(":userId", $cartItemModel->userId);
        $stm->bindValue(":productId", $cartItemModel->productId);
        $stm->execute();

        return EntityMaker::makeCartItemFromArray($stm->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @param int $userId
     * @return CartItem[]
     */
    public function getCartItemsByUser(int $userId): array
    {
        $stm = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :userId");
        $stm->bindValue(":userId", $userId);
        $stm->execute();

        return EntityMaker::makeCartListFromArray($stm->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param int $userId
     * @return CartItemPriceModel[]
     */
    public function getCartItemsPriceByUser(int $userId): array
    {
        $stm = $this->connection->prepare("
            SELECT 
                c.user_id as user_id, 
                c.product_id as product_id,
                c.quantity as quantity, 
                p.price as price_per_unit
            FROM cart c
            INNER JOIN product p
            ON c.product_id = p.id
            WHERE c.user_id = :userId");
        $stm->bindValue(":userId", $userId);
        $stm->execute();

        return DTOMaker::makeCartItemPriceModelList($stm->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param CartItemModel $cartItemModel
     * @return bool
     */
    public function addCartItem(CartItemModel $cartItemModel): bool
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
    public function updateCartItem(CartItem $cartItem): bool
    {
        $stm = $this->connection->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :userId AND product_id = :productId");
        $stm->bindValue(":userId", $cartItem->getUserId());
        $stm->bindValue(":productId", $cartItem->getProductId());
        $stm->bindValue(":quantity", $cartItem->getQuantity());
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param CartItem $cartItem
     * @return bool
     */
    public function removeCartItem(CartItem $cartItem): bool
    {
        $stm = $this->connection->prepare("DELETE FROM cart WHERE user_id = :userId AND product_id = :productId");
        $stm->bindValue(":userId", $cartItem->getUserId());
        $stm->bindValue(":productId", $cartItem->getProductId());
        return $stm->execute();
    }

    /**
     * @param array $sessionUser
     * @return CartItemViewModel[]
     */
    public function getCartItemViewListByUser(array $sessionUser): array
    {
        $stm = $this->connection->prepare(
            "SELECT 
                           p.name as productName, 
                           p.id as productId, 
                           c.quantity as quantity, 
                           p.price as price 
                       FROM cart c
                       INNER JOIN product p
                       ON c.product_id = p.id
                       WHERE c.user_id = :userId");
        $stm->bindValue(":userId", $sessionUser["id"]);
        $stm->execute();

        return DTOMaker::makeCartItemViewModelList($stm->fetchAll(\PDO::FETCH_ASSOC));
    }
}
