<?php
namespace Controller;

use Manager\ProductManager;
use Provider\RouteProvider;

class DefaultController extends GeneralController
{
    /**
     * @return string
     */
    public function homepage(): string
    {
        $productManager = new ProductManager();

        return $this->renderTemplate('homepage.php',  [
            'productList' => $productManager->getProductList(),
            'url' => [
                'cartApiAddProduct' => $this->routeProvider->getUrl(RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT)
            ],
            'pageTitle' => 'Homepage',
        ]);
    }

    /**
     * @return string
     */
    public function error404(): string
    {
        return $this->renderTemplate('error404.php',  [
            'pageTitle' => 'Error 404',
        ]);
    }
}
