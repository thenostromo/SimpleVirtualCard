<?php
namespace Controller\Api;

use Manager\ProductManager;
use Provider\ApiProvider;
use Response\ApiResponse;

class CartApiController
{
    /**
     * @param array $postParams
     * @return string
     */
    public function addProduct(array $postParams)
    {
        $response = null;
        var_dump($postParams); exit();
        //try {
            /* $userManager = new UserManager();
             $userManager->createUser($request);*/

        //}
        /* catch (EmptyRequiredParamsException $ex) {
            $response = new ApiResponse(
                GeneralProvider::API_RESPONSE_STATUS_FAILED,
                InterfaceProvider::getInterfaceMessage("form_error_api.empty_required_parameters")
            );
        }*/
        $response = new ApiResponse(ApiProvider::API_RESPONSE_STATUS_SUCCESS);
        return json_encode($response);
    }
}
