<?php
namespace Controller;

use Exception\CouldNotUpdateTableException;
use Exception\NotEnoughMoneyException;
use FormHandler\CreateOrderFormHandler;
use Manager\OrderManager;
use Provider\RouteProvider;
use Exception\EmptyRequiredParamsException;

class OrderController extends GeneralController
{
    /**
     * @param array $postParams
     */
    public function makeOrder(array $postParams)
    {
        if (!$this->sessionManager->isAuthorizedUser())
        {
            $this->redirect($this->routeProvider->getUrl(RouteProvider::SECURITY_CONTROLLER_LOGIN));
        }

        try
        {
            $createOrderFormHandler = new CreateOrderFormHandler();
            $orderModel = $createOrderFormHandler->handleForm($postParams);
            $orderModel->userId = $this->sessionManager->getSessionInfo()["id"];

            $orderManager = new OrderManager();
            $orderManager->makeOrder($orderModel, $this->sessionManager->getSessionInfo());
        }
        catch (EmptyRequiredParamsException $ex)
        {
            //
        }
        catch (CouldNotUpdateTableException $ex)
        {
            //
        }
        catch (NotEnoughMoneyException $ex)
        {
            //
        }

        $this->redirect($this->routeProvider->getUrl(RouteProvider::PROFILE_CONTROLLER_CART));
    }
}
