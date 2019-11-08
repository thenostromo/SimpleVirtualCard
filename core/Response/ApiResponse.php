<?php
namespace Response;

use Provider\ApiProvider;

class ApiResponse
{
    /**
     * @var int
     */
    public $status;

    /**
     * @var string|null
     */
    public $message;

    /**
     * @var array
     */
    public $payload;

    /**
     * ApiResponse constructor.
     * @param int $status
     * @param string|null $message
     * @param array $payload
     */
    public function __construct(
        $status = ApiProvider::API_RESPONSE_STATUS_SUCCESS,
        string $message = null,
        array $payload = []
    ) {
        $this->status = $status;
        $this->message = $message;
        $this->payload = $payload;
    }
}