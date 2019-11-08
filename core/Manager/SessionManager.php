<?php
namespace Manager;

use Entity\User;

class SessionManager
{
    public function __construct()
    {
        if (!$this->isSessionStarted()) {
            session_start();
        }
    }

    /**
     * @param User $user
     */
    public function sessionStart(User $user)
    {
        if (!$this->isAuthUser()) {
            $_SESSION["id"] = $user->getId();
            $_SESSION["email"] = $user->getEmail();
            $_SESSION["fullname"] = $user->getFullname();
        }
    }

    /**
     * @return bool
     */
    public function isSessionStarted()
    {
        return !(session_status() == PHP_SESSION_NONE);
    }

    /**
     * @return bool
     */
    public function isAuthorizedUser()
    {
        return array_key_exists("id", $_SESSION) && $_SESSION["id"];
    }

    /**
     * @return array
     */
    public function getSessionInfo()
    {
        return $_SESSION;
    }

    public function sessionStop()
    {
        unset($_SESSION);

        session_destroy();
    }
}