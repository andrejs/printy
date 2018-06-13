<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class JsonSuccess
 */
class JsonSuccess extends JsonResponse
{
    public function __construct($data = [], $status = Response::HTTP_OK, array $headers = [], $options = 0)
    {
        $data = [
            'success' => true,
        ] + $data;

        parent::__construct($data, $status, $headers, $options);
    }
}
