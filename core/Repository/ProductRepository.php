<?php
namespace Repository;

use Entity\Product;
use Maker\EntityMaker;

class ProductRepository
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
     * @return Product[]
     */
    public function getProductList(): array
    {
        $stm = $this->connection->prepare("SELECT * FROM product");
        $stm->execute();

        return EntityMaker::makeProductListFromArray($stm->fetchAll(\PDO::FETCH_ASSOC));
    }
}
