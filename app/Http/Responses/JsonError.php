<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class JsonError
 */
class JsonError extends JsonResponse
{
    public function __construct($data = [], $status = Response::HTTP_INTERNAL_SERVER_ERROR, array $headers = [], $options = 0)
    {
        $data = [
            'success' => false,
            'errors' => (array)$data,
        ];

        parent::__construct($data, $status, $headers, $options);
    }
}
