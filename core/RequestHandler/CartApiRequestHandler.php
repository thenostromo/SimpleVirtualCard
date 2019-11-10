<?php
namespace RequestHandler;

use DTO\CartItemModel;
use Provider\RouteProvider;
use Validator\FormValidator;
use Exception\EmptyRequiredParamsException;

class CartApiRequestHandler
{
    /**
     * @var CartItemModel|null
     */
    private $cartItemModel;

    /**
     * CartApiRequestHandler constructor.
     */
    public function __construct()
    {
        $this->cartItemModel = null;
    }

    /**
     * @param array $postParams
     * @param string $target
     * @throws EmptyRequiredParamsException
     */
    public function handleRequest(array $postParams, string $target)
    {
        if ($target === RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT
            || $target === RouteProvider::API_CART_API_CONTROLLER_ADD_PRODUCT_UNIT
            || $target === RouteProvider::API_CART_API_CONTROLLER_REMOVE_PRODUCT_UNIT) {
            $this->handleChangeCart($postParams);
        }
    }

    /**
     * @param array $postParams
     * @throws EmptyRequiredParamsException
     */
    private function handleChangeCart(array $postParams)
    {
        if ($this->emptyChangeCartPostParam($postParams))
        {
            throw new EmptyRequiredParamsException();
        }

        $cartItemModel = new CartItemModel();
        $cartItemModel->productId = FormValidator::prepareData($postParams["productId"]);
        $cartItemModel->quantity = FormValidator::prepareData($postParams["quantityValue"]);

        if ($this->emptyChangeCartModelParam($cartItemModel))
        {
            throw new EmptyRequiredParamsException();
        }

        $this->cartItemModel = $cartItemModel;
    }

    /**
     * @param array $postParams
     * @return bool
     */
    public function emptyChangeCartPostParam(array $postParams): bool
    {
        return (!array_key_exists("productId", $postParams)
            || !array_key_exists("quantityValue", $postParams));
    }

    /**
     * @param CartItemModel $cartItemModel
     * @return bool
     */
    public function emptyChangeCartModelParam(CartItemModel $cartItemModel): bool
    {
        return ($cartItemModel->productId === "" || $cartItemModel->quantity === "");
    }

    /**
     * @return CartItemModel
     */
    public function getCartItemModel(): CartItemModel
    {
        return $this->cartItemModel;
    }
}
