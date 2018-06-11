<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonError
 */
class JsonError extends JsonResponse
{
    public function __construct($data = [], $status = 500, array $headers = [], $options = 0)
    {
        $data = [
            'success' => false,
            'errors' => (array)$data,
        ];

        parent::__construct($data, $status, $headers, $options);
    }
}
