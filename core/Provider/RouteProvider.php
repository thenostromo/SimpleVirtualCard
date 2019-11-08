<?php
namespace Provider;

class RouteProvider
{
    const SECURITY_CONTROLLER_LOGIN = "login";
    const SECURITY_CONTROLLER_REGISTRATION = "registration";
    const SECURITY_CONTROLLER_LOGOUT = "logout";

    const DEFAULT_CONTROLLER_HOMEPAGE = "/";
    const HOST_WITH_SCHEME = "hostWithScheme";

    const API_CART_API_CONTROLLER_ADD_PRODUCT = "addProduct";

    /**
     * @param string $controller
     * @param bool $isFullUrl
     * @return string|null
     */
    public function getUrl($controller)
    {
        $mainUrl = sprintf("%s%s",
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"),
            "://$_SERVER[HTTP_HOST]"
        );
        switch (true) {
            case($this->isApiControllers($controller)):
                return sprintf("%s/api/%s", $mainUrl, $controller);
                break;
            case($this->isMainControllers($controller)):
                if ($controller === RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE || $controller === RouteProvider::HOST_WITH_SCHEME) {
                    return $mainUrl;
                }
                return sprintf("%s/%s", $mainUrl, $controller);
                break;
            case($this->isProfileControllers($controller)):
                return sprintf("%s/profile/%s", $mainUrl, $controller);
                break;
            default:
                return null;
        }
    }

    /**
     * @param string $controller
     * @param bool $isFullUrl
     * @return string|null
     */
    public function getRoute($controller)
    {
        switch (true) {
            case($this->isApiControllers($controller)):
                return sprintf("/api/%s", $controller);
                break;
            case($this->isMainControllers($controller)):
                if ($controller === RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE || $controller === RouteProvider::HOST_WITH_SCHEME) {
                    return $controller;
                }
                return sprintf("/%s", $controller);
                break;
            case($this->isProfileControllers($controller)):
                //return sprintf("/profile/%s", $mainUrl);
                break;
            default:
                return null;
        }
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isApiControllers(string $controller)
    {
        return ($controller === RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT);
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isMainControllers(string $controller)
    {
        return ($controller === RouteProvider::SECURITY_CONTROLLER_REGISTRATION
            || $controller === RouteProvider::SECURITY_CONTROLLER_LOGIN
            || $controller === RouteProvider::SECURITY_CONTROLLER_LOGOUT
            || $controller === RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE
            || $controller === RouteProvider::HOST_WITH_SCHEME);
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isProfileControllers(string $controller)
    {return false;
        //return ($controller === RouteProvider::PROFILE_CONTROLLER_VIEW);
    }
}