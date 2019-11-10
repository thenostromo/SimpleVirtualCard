<?php
namespace Maker;

use DTO\CartItemModel;
use DTO\CartItemPriceModel;
use DTO\CartItemViewModel;
use DTO\OrderItemPriceModel;
use DTO\OrderModel;
use DTO\OrderViewModel;
use DTO\ProductModel;
use Entity\CartItem;
use Entity\Order;
use Entity\Product;

class DTOMaker
{
    /**
     * @param Product[] $array
     * @return ProductModel[]
     */
    public static function makeProductModelListFromArray(array $array): array
    {
        $result = [];
        /** @var ProductModel $product */
        foreach ($array as $product)
        {
            $productModel = new ProductModel();
            $productModel->id = $product->getId();
            $productModel->name = $product->getName();
            $productModel->price = $product->getPrice();

            $result[] = $productModel;
        }
        return $result;
    }

    /**
     * @param array $array
     * @return CartItemViewModel[]
     */
    public static function makeCartItemViewModelList(array $array): array
    {
        $result = [];
        /** @var array $item */
        foreach ($array as $item)
        {
            $cartItemViewModel = new CartItemViewModel();
            $cartItemViewModel->productId = $item["productId"];
            $cartItemViewModel->productName = $item["productName"];
            $cartItemViewModel->quantity = $item["quantity"];
            $cartItemViewModel->price = $item["price"];

            $result[] = $cartItemViewModel;
        }
        return $result;
    }

    /**
     * @param array $array
     * @return CartItemPriceModel[]
     */
    public static function makeCartItemPriceModelList(array $array): array
    {
        $result = [];
        /** @var array $item */
        foreach ($array as $item)
        {
            $cartItemPriceModel = new CartItemPriceModel();
            $cartItemPriceModel->userId = $item["user_id"];
            $cartItemPriceModel->productId = $item["product_id"];
            $cartItemPriceModel->quantity = $item["quantity"];
            $cartItemPriceModel->pricePerUnit = $item["price_per_unit"];

            $result[] = $cartItemPriceModel;
        }
        return $result;
    }

    /**
     * @param Order[] $array
     * @return OrderModel[]
     */
    public static function makeOrderModelListFromArray(array $array): array
    {
        $result = [];
        /** @var Order $orderItem */
        foreach ($array as $orderItem)
        {
            $orderModel = new OrderModel();
            $orderModel->id = $orderItem->getId();
            $orderModel->userId = $orderItem->getUserId();
            $orderModel->transportType = $orderItem->getTransportType();
            $orderModel->status = $orderItem->getStatus();

            $result[] = $orderModel;
        }
        return $result;
    }

    /**
     * @param array $array
     * @return OrderItemPriceModel[]
     */
    public static function makeOrderItemPriceModelList(array $array): array
    {
        $result = [];
        /** @var array $item */
        foreach ($array as $item)
        {
            $orderItemPriceModel = new OrderItemPriceModel();
            $orderItemPriceModel->productId = $item["product_id"];
            $orderItemPriceModel->quantity = $item["quantity"];
            $orderItemPriceModel->pricePerUnit = $item["price_per_unit"];

            $result[] = $orderItemPriceModel;
        }
        return $result;
    }

    /**
     * @param array $array
     * @return OrderViewModel[]
     */
    public static function makeOrderViewModelList(array $array): array
    {
        $result = [];
        /** @var Order $item */
        foreach ($array as $item)
        {
            $orderViewModel = new OrderViewModel();
            $orderViewModel->id = $item->getId();
            $orderViewModel->userId = $item->getUserId();
            $orderViewModel->transportType = $item->getTransportType();
            $orderViewModel->status = $item->getStatus();

            $result[] = $orderViewModel;
        }
        return $result;
    }
}