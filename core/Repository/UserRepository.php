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
    public function createUser(UserModel $userModel, string $hashedPassword, string $salt): bool
    {
        $stm = $this->connection->prepare("INSERT INTO user (email, password, salt, fullname, balance) VALUES (:email, :password, :salt, :fullname, :balance)");
        $stm->bindValue(":email", $userModel->email);
        $stm->bindValue(":password", $hashedPassword);
        $stm->bindValue(":salt", $salt);
        $stm->bindValue(":fullname", $userModel->fullname);
        $stm->bindValue(":balance", $userModel->balance);

        return $stm->execute();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function updateUserBalance(User $user): bool
    {
        $stm = $this->connection->prepare("UPDATE user SET balance = :balance WHERE id = :userId");
        $stm->bindValue(":balance", $user->getBalance());
        $stm->bindValue(":userId", $user->getId());

        return $stm->execute();
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserInfoByEmail(string $email): ?User
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
