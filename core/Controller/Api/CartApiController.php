<?php
namespace Controller\Api;

use Manager\ProductManager;
use Provider\ApiProvider;
use Response\ApiResponse;

class CartApiController
{
    /**
     * @param array $request
     * @return string
     */
    public function addProduct(array $request)
    {
        $response = null;
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
