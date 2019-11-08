<?php
namespace FormHandler;

use DTO\UserModel;
use Manager\UserManager;
use Validator\FormValidator;
use Exception\EmptyRequiredParamsException;

class SecurityFormHandler
{
    public function handleRegistrationForm(array $postParams)
    {
        if ($this->emptyRegistrationFormParam($postParams)) {
            throw new EmptyRequiredParamsException();
        }

        $userModel = new UserModel();
        $userModel->password = FormValidator::prepareData($postParams["fieldPassword"]);
        $userModel->email = FormValidator::prepareData($postParams["fieldEmail"]);
        $userModel->fullname = FormValidator::prepareData($postParams["fieldFullName"]);

        if ($this->emptyRegistrationFormParam($postParams)) {
            throw new EmptyRequiredParamsException();
        }

        $userManager = new UserManager();
        $userManager->createUser($userModel);
    }

    /**
     * @param array $postParams
     * @return UserModel
     */
    public function getRegistrationFormData(array $postParams)
    {
        $userModel = new UserModel();
        $userModel->password = array_key_exists("fieldPassword", $postParams) ? $postParams["fieldPassword"] : null;
        $userModel->email = array_key_exists("fieldEmail", $postParams) ? $postParams["fieldEmail"] : null;
        $userModel->fullname = array_key_exists("fieldFullName", $postParams) ? $postParams["fieldFullName"] : null;
        return $userModel;
    }

    /**
     * @param UserModel $userModel
     * @return bool
     */
    private function emptyRegistrationFormUserModel(UserModel $userModel)
    {
        return (!$userModel->password || !$userModel->email || !$userModel->fullname);
    }

    /**
     * @param array $postParams
     * @return bool
     */
    private function emptyRegistrationFormParam(array $postParams)
    {
        return (!array_key_exists("fieldEmail", $postParams)
            || !array_key_exists("fieldPassword", $postParams)
            || !array_key_exists("fieldFullName", $postParams));
    }
}