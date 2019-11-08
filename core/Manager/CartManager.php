<?php
namespace Manager;

use DTO\CartItemModel;
use DTO\ProductModel;
use Entity\Product;
use Maker\DTOMaker;
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
    public function addCartItem(CartItemModel $cartItemModel)
    {
        $existCartItem = $this->cartItemRepository->getCartItem($cartItemModel);

        if ($existCartItem) {
            $existQuantity = $existCartItem->getQuantity();
            $newQuantity = $existQuantity + intval($cartItemModel->quantity);
            $existCartItem->setQuantity($newQuantity);

            $this->cartItemRepository->updateCartItem($existCartItem);
        } else {
            $this->cartItemRepository->addCartItem($cartItemModel);
        }
    }

    /**
     * @return ProductModel[] array
     */
    public function getProductList()
    {
        /** @var Product[] $productList */
        $productList = $this->productRepository->getProductList();

        return DTOMaker::makeProductModelListFromArray($productList);
    }
}
