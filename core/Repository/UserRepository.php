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
     * @param UserModel $userModel
     * @param string $hashedPassword
     * @param string $salt
     * @return mixed
     */
    public function createUser($userModel, $hashedPassword, $salt)
    {
        $stm = $this->connection->prepare("INSERT INTO user (email, password, salt, fullname, balance) VALUES (:email, :password, :salt, :fullname, :balance)");
        $stm->bindValue(":email", $userModel->email);
        $stm->bindValue(":password", $hashedPassword);
        $stm->bindValue(":salt", $salt);
        $stm->bindValue(":fullname", $userModel->fullname);
        $stm->bindValue(":balance", $userModel->balance);
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function getUserInfoByEmail(string $email)
    {
        $stm = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stm->bindValue(":email", $email);
        $stm->execute();

        return EntityMaker::makeUserFromArray($stm->fetch(\PDO::FETCH_ASSOC));
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
