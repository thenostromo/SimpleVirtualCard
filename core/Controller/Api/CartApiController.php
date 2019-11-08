<?php
namespace Controller\Api;

use DTO\CartItemModel;
use Exception\EmptyRequiredParamsException;
use Manager\CartManager;
use Manager\SessionManager;
use Provider\ApiProvider;
use Provider\RouteProvider;
use RequestHandler\CartApiRequestHandler;
use Response\ApiResponse;

class CartApiController
{
    /**
     * @var CartManager
     */
    private $cartManager;

    /**
     * @var SessionManager
     */
    private $sessionManager;

    public function __construct()
    {
        $this->cartManager = new CartManager();
        $this->sessionManager = new SessionManager();
    }

    /**
     * @param array $postParams
     * @return false|string
     */
    public function addProduct(array $postParams)
    {
        $response = null;

        try {
            $cartApiRequestHandler = new CartApiRequestHandler();
            $cartApiRequestHandler->handleRequest($postParams, RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT);

            $cartItemModel = $cartApiRequestHandler->getCartItemModel();
            $cartItemModel->userId = $this->sessionManager->getSessionInfo()["id"];

            $this->cartManager->addCartItem($cartItemModel);
            $response = new ApiResponse(ApiProvider::API_RESPONSE_STATUS_SUCCESS);
        } catch (EmptyRequiredParamsException $ex) {
            $response = new ApiResponse(ApiProvider::API_RESPONSE_STATUS_FAILED, "Check the correctness of the entered data");
        }

        return json_encode($response);
    }
}
