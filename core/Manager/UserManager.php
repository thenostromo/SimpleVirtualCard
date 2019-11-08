<?php
namespace Manager;

use DTO\UserModel;
use Exception\UserAlreadyExistException;
use Repository\UserRepository;

class UserManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct()
    {
        $databaseManager = new DatabaseManager();
        $connection = $databaseManager->getConnection();

        $this->userRepository = new UserRepository($connection);
    }

    private function generateUserSalt()
    {
        $Blowfish_Pre = '$2a$05$';
        $Blowfish_End = '$';
        $Allowed_Chars =
            'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $Chars_Len = 63;
        $Salt_Length = 21;
        $mysql_date = date( 'Y-m-d' );
        $salt = "";
        for($i=0; $i<=$Salt_Length; $i++)
        {
            $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
        }
        $bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
        return $bcrypt_salt;
    }

    /**
     * @param UserModel $request
     * @throws UserAlreadyExistException
     */
    public function createUser(UserModel $userModel)
    {
        if ($this->userRepository->isUserExist($userModel)) {
            throw new UserAlreadyExistException();
        }

        $bcrypt_salt = $this->generateUserSalt();
        $hashed_password = crypt($userModel->password, $bcrypt_salt);

        /*
         * $sql = "SELECT salt, password FROM users WHERE email='$email'";
$result = mysql_query($sql) or die( mysql_error() );
$row = mysql_fetch_assoc($result);
$hashed_pass = crypt($password, $Blowfish_Pre . $row['salt'] . $Blowfish_End);
if ($hashed_pass == $row['password']) {
    echo 'Password verified!';
} else {
    echo 'There was a problem with your user name or password.';
}
         */
        var_dump($hashed_password, $bcrypt_salt, $userModel); exit();
var_dump(123); exit();

        $this->databaseManager->createUser($userModel);
    }

    /**
     * @param array $request
     * @throws EmptyRequiredParamsException
     * @throws InvalidDataException
     * @throws WrongCredentialsException
     */
    public function authUser(array $request)
    {
        $username = array_key_exists("username", $request) ? $request["username"] : null;
        $password = array_key_exists("password", $request) ? $request["password"] : null;

        if (!$username || !$password) {
            throw new EmptyRequiredParamsException();
        }

        $userModel = new UserModel();
        $userModel->username = FormValidator::prepareData($username);
        $userModel->password = FormValidator::prepareData($password);

        if (!FormValidator::isValidAuthForm($userModel)) {
            throw new InvalidDataException();
        }

        $userInfo = $this->databaseManager->getUserInfo($userModel);

        if (!$userInfo) {
            throw new WrongCredentialsException();
        }

        $user = new User();
        $user->makeFromArray($userInfo);

        $this->sessionManager->sessionStart($user);
    }
}