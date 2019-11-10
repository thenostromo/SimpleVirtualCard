<?php
namespace Provider;

class RouteProvider
{
    const SECURITY_CONTROLLER_LOGIN = "login";
    const SECURITY_CONTROLLER_REGISTRATION = "registration";
    const SECURITY_CONTROLLER_LOGOUT = "logout";

    const DEFAULT_CONTROLLER_HOMEPAGE = "/";
    const HOST_WITH_SCHEME = "hostWithScheme";

    const PROFILE_CONTROLLER_CART = "cart";

    const ORDER_CONTROLLER_MAKE_ORDER = "makeOrder";

    const API_CART_API_CONTROLLER_ADD_PRODUCT = "addProduct";
    const API_CART_API_CONTROLLER_ADD_PRODUCT_UNIT = "addProductUnit";
    const API_CART_API_CONTROLLER_REMOVE_PRODUCT_UNIT = "removeProductUnit";
    const API_CART_API_CONTROLLER_REMOVE_PRODUCT = "removeProduct";

    /**
     * @param string $controller
     * @return string|null
     */
    public function getUrl(string $controller): ?string
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
                if ($controller === self::DEFAULT_CONTROLLER_HOMEPAGE || $controller === self::HOST_WITH_SCHEME) {
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
     * @return string|null
     */
    public function getRoute(string $controller): ?string
    {
        switch (true) {
            case($this->isApiControllers($controller)):
                return sprintf("/api/%s", $controller);
                break;
            case($this->isMainControllers($controller)):
                if ($controller === self::DEFAULT_CONTROLLER_HOMEPAGE || $controller === self::HOST_WITH_SCHEME) {
                    return $controller;
                }
                return sprintf("/%s", $controller);
                break;
            case($this->isProfileControllers($controller)):
                return sprintf("/profile/%s", $controller);
                break;
            default:
                return null;
        }
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isApiControllers(string $controller): bool
    {
        return ($controller === self::API_CART_API_CONTROLLER_ADD_PRODUCT
            || $controller === self::API_CART_API_CONTROLLER_ADD_PRODUCT_UNIT
            || $controller === self::API_CART_API_CONTROLLER_REMOVE_PRODUCT_UNIT
            || $controller === self::API_CART_API_CONTROLLER_REMOVE_PRODUCT);
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isMainControllers(string $controller): bool
    {
        return ($controller === self::SECURITY_CONTROLLER_REGISTRATION
            || $controller === self::SECURITY_CONTROLLER_LOGIN
            || $controller === self::SECURITY_CONTROLLER_LOGOUT
            || $controller === self::DEFAULT_CONTROLLER_HOMEPAGE
            || $controller === self::HOST_WITH_SCHEME);
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isProfileControllers(string $controller): bool
    {
        return ($controller === self::PROFILE_CONTROLLER_CART
            || $controller === self::ORDER_CONTROLLER_MAKE_ORDER);
    }
}