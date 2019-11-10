<?php
namespace Manager;

use DTO\UserModel;
use Entity\User;
use Exception\UserAlreadyExistException;
use Exception\WrongCredentialsException;
use Reader\ParameterReader;
use Repository\UserRepository;
use Worker\PasswordWorker;

class UserManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordWorker
     */
    private $passwordWorker;

    public function __construct()
    {
        $databaseManager = new DatabaseManager();
        $connection = $databaseManager->getConnection();

        $this->userRepository = new UserRepository($connection);
        $this->passwordWorker = new PasswordWorker();
    }

    /**
     * @param UserModel $userModel
     * @throws UserAlreadyExistException
     */
    public function createUser(UserModel $userModel)
    {
        if ($this->userRepository->isUserExist($userModel))
        {
            throw new UserAlreadyExistException();
        }

        $salt = $this->passwordWorker->generateUserSalt();
        $hashedPassword = crypt($userModel->password, $salt);

        $parameterReader = new ParameterReader();
        $userModel->balance = $parameterReader->parameters["default_user_balance"];

        $this->userRepository->createUser($userModel, $hashedPassword, $salt);
    }

    /**
     * @param UserModel $userModel
     * @throws WrongCredentialsException
     */
    public function authUser(UserModel $userModel)
    {
        /** @var User $foundUser */
        $foundUser = $this->userRepository->getUserInfoByEmail($userModel->email);

        if (!$foundUser || !$this->passwordWorker->isPasswordValid($userModel->password, $foundUser->getPassword(), $foundUser->getSalt()))
        {
            throw new WrongCredentialsException();
        }

        $sessionManager = new SessionManager();
        $sessionManager->sessionStart($foundUser);
    }
}