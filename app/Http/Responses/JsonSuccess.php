<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonSuccess
 */
class JsonSuccess extends JsonResponse
{
    public function __construct($data = [], $status = 200, array $headers = [], $options = 0)
    {
        $data = [
            'success' => true,
        ] + $data;

        parent::__construct($data, $status, $headers, $options);
    }
}
