<?php
namespace Controller;

use DTO\UserModel;
use Exception\EmptyRequiredParamsException;
use Provider\RouteProvider;
use FormHandler\SecurityFormHandler;

class SecurityController extends GeneralController
{
    /**
     * @var SecurityFormHandler
     */
    private $securityFormHandler;

    public function __construct()
    {
        parent::__construct();
        $this->securityFormHandler = new SecurityFormHandler();
    }

    /**
     * @param array $postParams
     * @return string
     */
    public function login(array $postParams)
    {
        $userModel = new UserModel();
        if ($this->sessionManager->isAuthorizedUser()) {
            $this->redirect($this->routeProvider->getUrl(RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE));
        }

        return $this->renderTemplate('login.php', [
            'userModel' => json_encode($userModel),
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
            $userModel = $this->securityFormHandler->getRegistrationFormData($postParams);
            try {
                $result = $this->securityFormHandler->handleRegistrationForm($postParams);
            } catch (EmptyRequiredParamsException $ex) {
                $errorMessage = "Check the correctness of the entered data";
            }
        }
        return $this->renderTemplate('registration.php', [
            'userModel' => $userModel,
            'errorMessage' => $errorMessage,
            'pageTitle' => 'Registration',
        ]);
    }
}