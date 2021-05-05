<?php


namespace App\Traits;


trait Responder
{

    public function error(string $message, int $code = 403, \Exception $exception = null) : array {
        return [
            'status' => false,
            'message' => $message,
            'code' => $code,
            'data' => null,
            'issue' => $exception
        ];
    }

    public function success($response, int $code = 200, string $message = "") : array {
        return [
            'status' => true,
            'message' => $message,
            'code' => $code,
            'data' => $response,
            'issue' => null
        ];
    }
}
