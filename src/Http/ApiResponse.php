<?php

namespace App\Http;

use ArrayObject;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse {

    /**
     * @param string $message
     * @param $data 
     * @param array $errors 
     * @param int $status 
     * @param array $headers 
     * @param bool $json
     */
    public function __construct(string $message, $data = null , array $errors = [], int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct( $this->format( $message, $data, $errors ), $status, $headers, $json );
    }

    /**
     * 
     * For formating the response body
     * 
     * @param string $message 
     * @param $data 
     * @param array $errors
     */
    private function format(string $message, $data = null, array $errors = []) {

        if($data === null) {
            $data = new ArrayObject();
        }

        $response = [
            "message" => $message,
            "data" => $data
        ];

        if($errors) {
            $response["errors"] = $errors;
        }

        return $response;

    }

}