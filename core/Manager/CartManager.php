<?php
namespace Manager;

use DTO\CartItemModel;
use DTO\CartItemViewModel;
use Entity\CartItem;
use Repository\CartItemRepository;

class CartManager
{
    /**
     * @var CartItemRepository
     */
    private $cartItemRepository;

    public function __construct()
    {
        $databaseManager = new DatabaseManager();

        $this->cartItemRepository = new CartItemRepository($databaseManager->getConnection());
    }

    /**
     * @param CartItemModel $cartItemModel
     */
    public function changeCart(CartItemModel $cartItemModel)
    {
        /** @var CartItem|bool $existCartItem */
        $existCartItem = $this->cartItemRepository->getCartItem($cartItemModel);

        if ($existCartItem instanceof CartItem)
        {
            $newQuantity = intval($cartItemModel->quantity);

            if ($newQuantity === 0)
            {
                $this->cartItemRepository->removeCartItem($existCartItem);
            }

            $existCartItem->setQuantity($newQuantity);
            $this->cartItemRepository->updateCartItem($existCartItem);
        }
        else
        {
            $this->cartItemRepository->addCartItem($cartItemModel);
        }
    }

    /**
     * @param array $sessionUser
     * @return CartItemViewModel[]
     */
    public function getCartItemViewList(array $sessionUser): array
    {
        return $this->cartItemRepository->getCartItemViewListByUser($sessionUser);
    }
}
