<?php
namespace Maker;

use DTO\ProductModel;
use Entity\Product;

class DTOMaker
{
    /**
     * @param Product[] $array
     * @return ProductModel[]
     */
    public static function makeProductModelListFromArray(array $array)
    {
        $result = [];
        foreach ($array as $product) {
            $productModel = new ProductModel();
            $productModel->id = $product->getId();
            $productModel->name = $product->getName();
            $productModel->price = $product->getPrice();

            $result[] = $productModel;
        }
        return $result;
    }
}