<?php
namespace Worker;

class PasswordWorker
{
    const CRYPT_METHOD_BLOWFISH = "CRYPT_BLOWFISH";

    /**
     * @param string $salt
     * @param string $cryptMethod
     * @return string
     */
    private function getCryptedSalt($salt, $cryptMethod)
    {
        if ($cryptMethod === self::CRYPT_METHOD_BLOWFISH) {
            return "$2a$05$" . $salt . "$";
        }
    }

    /**
     * @return string
     */
    public function generateUserSalt()
    {
        $allowedChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $allowedCharsLength = strlen($allowedChars);

        $salt = "";
        for ($i=0; $i<= 21; $i++) {
            $salt .= $allowedChars[
                mt_rand(
                    0,
                    ($allowedCharsLength - 1)
                )
            ];
        }

        return $this->getCryptedSalt($salt, self::CRYPT_METHOD_BLOWFISH);
    }

    /**
     * @param string $checkingPassword
     * @param string $savedPassword
     * @param string $salt
     * @return bool
     */
    public function isPasswordValid(string $checkingPassword, string $savedPassword, string $salt)
    {
        $checkingPassword = crypt($checkingPassword, $salt);
        return ($savedPassword == $checkingPassword);
    }
}