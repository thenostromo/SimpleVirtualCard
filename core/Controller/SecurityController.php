<?php
namespace Controller;

use DTO\UserModel;
use Exception\EmptyRequiredParamsException;
use Exception\UserAlreadyExistException;
use Exception\WrongCredentialsException;
use FormHandler\AuthorizationFormHandler;
use FormHandler\RegistrationFormHandler;
use Provider\RouteProvider;

class SecurityController extends GeneralController
{
    /**
     * @param array $postParams
     * @return string
     */
    public function login(array $postParams)
    {
        if ($this->sessionManager->isAuthorizedUser()) {
            $this->redirect($this->routeProvider->getUrl(RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE));
        }

        $errorMessage = null;
        $userModel = new UserModel();

        if (count($postParams) > 0) {
            $authorizationFormHandler = new AuthorizationFormHandler();
            $userModel = $authorizationFormHandler->getFormData($postParams);
            try {
                $result = $authorizationFormHandler->handleForm($postParams);
                $this->redirect($this->routeProvider->getUrl(RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE));
            } catch (WrongCredentialsException $ex) {
                $errorMessage = "Wrong credentials.";
            }
        }

        return $this->renderTemplate('login.php', [
            'userModel' => $userModel,
            'errorMessage' => $errorMessage,
            'pageTitle' => 'Sign in',
        ]);
    }

    /**
     * @return string
     */
    public function logout()
    {
        $this->sessionManager->sessionStop();
        $this->redirect($this->routeProvider->getUrl(RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE));
    }

    /**
     * @param array $postParams
     * @return string
     */
    public function registration(array $postParams)
    {
        if ($this->sessionManager->isAuthorizedUser()) {
            $this->redirect($this->routeProvider->getUrl(RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE));
        }

        $errorMessage = null;
        $userModel = new UserModel();

        if (count($postParams) > 0) {
            $registrationFormHandler = new RegistrationFormHandler();
            $userModel = $registrationFormHandler->getFormData($postParams);
            try {
                $result = $registrationFormHandler->handleForm($postParams);
                $this->redirect($this->routeProvider->getUrl(RouteProvider::SECURITY_CONTROLLER_LOGIN));
            } catch (EmptyRequiredParamsException $ex) {
                $errorMessage = "Check the correctness of the entered data";
            } catch (UserAlreadyExistException $ex) {
                $errorMessage = "This email is already registered.";
            }
        }

        return $this->renderTemplate('registration.php', [
            'userModel' => $userModel,
            'errorMessage' => $errorMessage,
            'pageTitle' => 'Registration',
        ]);
    }
}