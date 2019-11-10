<?php
namespace Controller;

use DTO\CartItemViewModel;
use DTO\OrderViewModel;
use Manager\CartManager;
use Manager\OrderManager;
use Provider\OrderProvider;
use Provider\RouteProvider;

class ProfileController extends GeneralController
{
    /**
     * @return string
     */
    public function cart(): string
    {
        if (!$this->sessionManager->isAuthorizedUser())
        {
            $this->redirect($this->routeProvider->getUrl(RouteProvider::SECURITY_CONTROLLER_LOGIN));
        }

        $cartManager = new CartManager();

        /** @var CartItemViewModel[] $cartItemList */
        $cartItemList = $cartManager->getCartItemViewList($this->sessionManager->getSessionInfo());

        $orderManager = new OrderManager();

        /** @var OrderViewModel $orderList */
        $orderList = $orderManager->getOrderList($this->sessionManager->getSessionInfo());

        return $this->renderTemplate('profile_cart.php', [
            'form' => [
                'transportTypeChoice' => OrderProvider::getTransportTypeChoice(),
                'transportTypePrice' => OrderProvider::getTransportTypePrice(),
                'orderStatusChoice' => OrderProvider::getOrderStatusChoice()
            ],
            'url' => [
                'cartApiAddProductUnit' => $this->routeProvider->getUrl(RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT_UNIT),
                'cartApiRemoveProductUnit' => $this->routeProvider->getUrl(RouteProvider::API_CART_API_CONTROLLER_REMOVE_PRODUCT_UNIT),
                'cartApiRemoveProduct' => $this->routeProvider->getUrl(RouteProvider::API_CART_API_CONTROLLER_REMOVE_PRODUCT),
                'makeOrder' => $this->routeProvider->getUrl(RouteProvider::ORDER_CONTROLLER_MAKE_ORDER)
            ],
            'orderList' => $orderList,
            'cartItemList' => $cartItemList,
            'pageTitle' => 'Your Cart',
        ]);
    }
}
