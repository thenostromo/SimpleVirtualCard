<?php
namespace Manager;

use DTO\ProductModel;
use Entity\Product;
use Maker\DTOMaker;
use Repository\ProductRepository;

class ProductManager
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct()
    {
        $databaseManager = new DatabaseManager();
        $this->productRepository = new ProductRepository($databaseManager->getConnection());
    }

    /**
     * @return ProductModel[] array
     */
    public function getProductList(): array
    {
        /** @var Product[] $productList */
        $productList = $this->productRepository->getProductList();

        return DTOMaker::makeProductModelListFromArray($productList);
    }
}
