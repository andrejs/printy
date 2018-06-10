<?php

namespace App\Services;

use App\Models\Product;

/**
 * Class ProductService
 */
class ProductService extends AbstractService
{
    public function findAll()
    {
        return Product::all();
    }
}
