<?php

namespace App\Services;

use App\Models\Product;

/**
 * Class ProductService
 */
class ProductService extends AbstractService
{
    /**
     * Find all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        return Product::all();
    }

    /**
     * Find products with exact type, color and size properties.
     *
     * @param string $type
     * @param string $color
     * @param string $size
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByProperties($type, $color, $size)
    {
        return Product::query()->where([
            ['type', $type],
            ['color', $color],
            ['size', $size],
        ])->get();
    }

    /**
     * @inheritdoc
     */
    public function createModel()
    {
        return new Product();
    }

    /**
     * @inheritdoc
     */
    public function find($id, $columns = ['*'])
    {
        return Product::query()->find($id, $columns);
    }

    /**
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function findProductPrices($id)
    {
        return $this->find($id, ['id', 'price']);
    }
}
