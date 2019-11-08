<?php
namespace FormHandler;

use DTO\UserModel;
use Manager\UserManager;
use Validator\FormValidator;
use Exception\EmptyRequiredParamsException;
use Exception\UserAlreadyExistException;

class AuthorizationFormHandler implements FormHandlerInterface
{
    /**
     * @param array $postParams
     * @throws EmptyRequiredParamsException
     * @throws UserAlreadyExistException
     */
    public function handleForm(array $postParams)
    {
        if ($this->emptyFormPostParam($postParams)) {
            throw new EmptyRequiredParamsException();
        }

        $userModel = new UserModel();
        $userModel->password = FormValidator::prepareData($postParams["fieldPassword"]);
        $userModel->email = FormValidator::prepareData($postParams["fieldEmail"]);

        if ($this->emptyFormModel($userModel)) {
            throw new EmptyRequiredParamsException();
        }

        $userManager = new UserManager();
        $userManager->authUser($userModel);
    }

    /**
     * @param array $postParams
     * @return UserModel
     */
    public function getFormData(array $postParams)
    {
        $userModel = new UserModel();
        $userModel->password = array_key_exists("fieldPassword", $postParams) ? $postParams["fieldPassword"] : null;
        $userModel->email = array_key_exists("fieldEmail", $postParams) ? $postParams["fieldEmail"] : null;
        return $userModel;
    }

    /**
     * @param UserModel $userModel
     * @return bool
     */
    public function emptyFormModel($userModel)
    {
        return (!$userModel->password || !$userModel->email);
    }

    /**
     * @param array $postParams
     * @return bool
     */
    public function emptyFormPostParam(array $postParams)
    {
        return (!array_key_exists("fieldEmail", $postParams)
            || !array_key_exists("fieldPassword", $postParams));
    }
}
