<?php
namespace FormHandler;

use DTO\OrderModel;
use Manager\OrderManager;
use Validator\FormValidator;
use Exception\EmptyRequiredParamsException;

class CreateOrderFormHandler implements FormHandlerInterface
{
    /**
     * @param array $postParams
     * @return OrderModel $orderModel
     * @throws EmptyRequiredParamsException
     */
    public function handleForm(array $postParams)
    {
        if ($this->emptyFormPostParam($postParams))
        {
            throw new EmptyRequiredParamsException();
        }

        $orderModel = new OrderModel();
        $orderModel->transportType = FormValidator::prepareData($postParams["transportType"]);

        if ($this->emptyFormModel($orderModel))
        {
            throw new EmptyRequiredParamsException();
        }

        return $orderModel;
    }

    /**
     * @param array $postParams
     * @return OrderModel
     */
    public function getFormData(array $postParams): OrderModel
    {
        $orderModel = new OrderModel();
        $orderModel->transportType = array_key_exists("transportType", $postParams) ? $postParams["transportType"] : null;
        return $orderModel;
    }

    /**
     * @param OrderModel $orderModel
     * @return bool
     */
    public function emptyFormModel($orderModel): bool
    {
        return ($orderModel->transportType === "");
    }

    /**
     * @param array $postParams
     * @return bool
     */
    public function emptyFormPostParam(array $postParams): bool
    {
        return (!array_key_exists("transportType", $postParams));
    }
}
