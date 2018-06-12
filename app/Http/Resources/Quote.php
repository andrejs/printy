<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Quote
 */
class Quote extends JsonResource
{
    /** @var Collection */
    protected $products;

    /**
     * Quote constructor.
     * @param mixed $resource
     * @param $products
     */
    public function __construct($resource, $products)
    {
        parent::__construct($resource);

        $this->products = $products;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
            'products' => new ProductQuoteCollection($this->products),
        ];
    }
}
