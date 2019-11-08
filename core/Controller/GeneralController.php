<?php
namespace Controller;

use Manager\SessionManager;
use Provider\RouteProvider;

class GeneralController
{
    /**
     * @var RouteProvider
     */
    protected $routeProvider;

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    public function __construct()
    {
        $this->routeProvider = new RouteProvider();
        $this->sessionManager = new SessionManager();
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function renderTemplate($template, $params)
    {
        $template = sprintf("%s/../templates/%s", __DIR__, $template);
        if (!file_exists($template)) {
            return '';
        }

        $params["hostWithScheme"] = $this->routeProvider->getUrl(RouteProvider::HOST_WITH_SCHEME);
        $params["isAuthorized"] = $this->sessionManager->isAuthorizedUser();
        $params["url"] = [
            "signIn" => $this->routeProvider->getUrl(RouteProvider::SECURITY_CONTROLLER_LOGIN),
            "registration" => $this->routeProvider->getUrl(RouteProvider::SECURITY_CONTROLLER_REGISTRATION),
            "logout" => $this->routeProvider->getUrl(RouteProvider::SECURITY_CONTROLLER_LOGOUT)
        ];

        if (!key_exists('pageTitle', $params)) {
            $params['pageTitle'] = 'SimpleVirtualCart';
        }

        if (is_array($params)){
            extract($params);
        }

        ob_start();
        include $template;
        return ob_get_clean();
    }

    /**
     * @param string $url
     */
    protected function redirect($url)
    {
        header('Location: ' . $url,true, 301);
    }
}
