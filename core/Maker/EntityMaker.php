<?php
namespace Maker;

use Entity\Product;

class EntityMaker
{
    /**
     * @param $array
     * @return array
     */
    public static function makeProductListFromArray($array)
    {
        $result = [];
        foreach ($array as $item) {
            $product = new Product();
            $product->setId($item["id"]);
            $product->setName($item["name"]);
            $product->setPriceDollar($item["price_dollar"]);

            $result[] = $product;
        }
        return $result;
    }
}