<?php
namespace Maker;

use Entity\Product;
use Entity\User;

class EntityMaker
{
    /**
     * @param $array
     * @return array
     */
    public static function makeProductListFromArray($array)
    {
        if (!is_array($array)) {
            return [];
        }
        $result = [];
        foreach ($array as $item) {
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
    public static function makeUserFromArray($item)
    {
        if (is_bool($item)) {
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
}