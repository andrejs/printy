<?php

namespace App\Services;

use App\Http\Responses\JsonError;
use App\Models\Quote;
use App\Models\ProductQuote;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class ProductQuoteService
 */
class ProductQuoteService extends AbstractService
{
    /**
     * @inheritdoc
     */
    public function createModel()
    {
        return new ProductQuote();
    }

    /**
     * @param array $fields
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function find($fields, $columns = ['*'])
    {
        return ProductQuote::query()->where($fields)->get($columns);
    }

    /**
     * @param Quote $quote
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByQuote(Quote $quote)
    {
        return ProductQuote::query()->where(['quote_id' => $quote->id])->get();
    }

    /**
     * @param Quote $quote
     * @param array $products
     */
    public function saveProductsForQuote(Quote $quote, array $products)
    {
        foreach ($products as $product) {
            $model = $this->createModel()->fill($product);
            $model->quote_id = $quote->id;

            if (!$this->save($model)) {
                throw new HttpResponseException(new JsonError('Error saving quote products'));
            };
        }
    }
}
