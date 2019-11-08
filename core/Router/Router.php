<?php
namespace Router;

use Controller\Api\CartApiController;
use Controller\DefaultController;
use Controller\SecurityController;
use Provider\RouteProvider;

class Router
{
    /**
     * @var array
     */
    private $controllers;

    /**
     * @var array
     */
    private $routeProvider;

    public function __construct()
    {
        $this->routeProvider = new RouteProvider();
        $this->controllers = [
            'default' => new DefaultController(),
            'security' => new SecurityController(),
            'cartApi' => new CartApiController()
        ];
    }

    /**
     * @param array $request
     * @return string
     */
    public function handleRequest()
    {
        $url = $_SERVER['REQUEST_URI'];

        $response = null;
        $response = $this->handleApiRequests($url, $_POST);
        if (!$response) {
            $response = $this->handleMainPages($url, $_POST);
        }
        return (!$response)
            ? $this->controllers['default']->error404()
            : $response;
    }

    /**
     * @param string $url
     * @param array $postParams
     * @return mixed
     */
    private function handleApiRequests(string $url, array $postParams = [])
    {
        switch($url) {
            case($this->routeProvider->getRoute(RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT)):
                return $this->controllers['cartApi']->addProduct($postParams);
                break;
        }
    }

    /**
     * @param string $url
     * @param array $postParams
     * @return string
     */
    private function handleMainPages(string $url, array $postParams = [])
    {
        switch($url) {
            case($this->routeProvider->getRoute(RouteProvider::DEFAULT_CONTROLLER_HOMEPAGE)):
                return $this->controllers['default']->homepage();
                break;
            case($this->routeProvider->getRoute(RouteProvider::SECURITY_CONTROLLER_LOGIN)):
                return $this->controllers['security']->login($postParams);
                break;
            case($this->routeProvider->getRoute(RouteProvider::SECURITY_CONTROLLER_REGISTRATION)):
                return $this->controllers['security']->registration($postParams);
                break;
            case($this->routeProvider->getRoute(RouteProvider::SECURITY_CONTROLLER_LOGOUT)):
                return $this->controllers['security']->logout();
                break;
        }
    }
}