<?php
namespace Maker;

use Entity\CartItem;
use Entity\Order;
use Entity\OrderItem;
use Entity\Product;
use Entity\User;

class EntityMaker
{
    /**
     * @param array $array
     * @return array
     */
    public static function makeProductListFromArray($array): array
    {
        if (!is_array($array))
        {
            return [];
        }
        $result = [];

        /** @var Product $item */
        foreach ($array as $item)
        {
            $product = new Product();
            $product->setId($item["id"]);
            $product->setName($item["name"]);
            $product->setPrice($item["price"]);

            $result[] = $product;
        }
        return $result;
    }

    /**
     * @param array $item
     * @return User|null
     */
    public static function makeUserFromArray($item): ?User
    {
        if (is_bool($item))
        {
            return null;
        }

        $user = new User();
        $user->setId($item["id"]);
        $user->setEmail($item["email"]);
        $user->setPassword($item["password"]);
        $user->setSalt($item["salt"]);
        $user->setFullname($item["fullname"]);
        $user->setBalance($item["balance"]);

        return $user;
    }

    /**
     * @param array|bool $item
     * @return CartItem|null
     */
    public static function makeCartItemFromArray($item): ?CartItem
    {
        if (is_bool($item))
        {
            return null;
        }

        $cartItem = new CartItem();
        $cartItem->setUserId($item["user_id"]);
        $cartItem->setProductId($item["product_id"]);
        $cartItem->setQuantity($item["quantity"]);

        return $cartItem;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function makeCartListFromArray($array): array
    {
        if (!is_array($array))
        {
            return [];
        }

        $result = [];
        foreach ($array as $item)
        {
            $cartItem = new CartItem();
            $cartItem->setUserId($item["user_id"]);
            $cartItem->setProductId($item["product_id"]);
            $cartItem->setQuantity($item["quantity"]);

            $result[] = $cartItem;
        }
        return $result;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function makeOrderListFromArray($array): array
    {
        if (!is_array($array))
        {
            return [];
        }

        $result = [];
        foreach ($array as $item)
        {
            $order = new Order();
            $order->setId($item["id"]);
            $order->setUserId($item["user_id"]);
            $order->setTransportType($item["transport_type"]);
            $order->setStatus($item["status"]);

            $result[] = $order;
        }
        return $result;
    }

    /**
     * @param array $item
     * @return Order|null
     */
    public static function makeOrderFromArray($item): ?Order
    {
        if (is_bool($item))
        {
            return null;
        }

        $order = new Order();
        $order->setId($item["id"]);
        $order->setUserId($item["user_id"]);
        $order->setTransportType($item["transport_type"]);
        $order->setStatus($item["status"]);
        $order->setIsFormed($item["is_formed"]);

        return $order;
    }

    /**
     * @param array $item
     * @return OrderItem|null
     */
    public static function makeOrderItemFromArray($item): ?OrderItem
    {
        if (is_bool($item))
        {
            return null;
        }

        $orderItem = new OrderItem();
        $orderItem->setOrderId($item["order_id"]);
        $orderItem->setProductId($item["product_id"]);
        $orderItem->setQuantity($item["quantity"]);

        return $orderItem;
    }
}