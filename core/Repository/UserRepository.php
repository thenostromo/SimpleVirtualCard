<?php
namespace Repository;

use DTO\UserModel;
use Entity\User;
use Maker\EntityMaker;

class UserRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * UserRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Product[]
     */
    public function getProductList()
    {
        $stm = $this->connection->prepare("SELECT * FROM product");
        $stm->execute();

        return EntityMaker::makeProductListFromArray($stm->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param UserModel $userModel
     * @return boolean
     */
    public function isUserExist($userModel)
    {
        $stm = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stm->bindValue(":email", $userModel->email);
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }
}
