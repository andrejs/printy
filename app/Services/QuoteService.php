<?php

namespace App\Services;

use App\Http\Responses\JsonError;
use App\Models\Quote;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class QuoteService
 */
class QuoteService extends AbstractService
{
    const DEFAULT_COUNTRY = 'US';

    /** @var ProductService */
    protected $product;

    public function __construct(ProductService $productService)
    {
        $this->product = $productService;
    }

    /**
     * Find all Quotes.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        return Quote::all();
    }

    /**
     * @inheritdoc
     */
    public function createModel()
    {
        return new Quote();
    }

    /**
     * @inheritdoc
     */
    public function find($id, $columns = ['*'])
    {
        return Quote::query()->find($id, $columns);
    }

    public function calculate($products)
    {
        $total = 0;

        foreach ($products as $item) {
            $product = $this->product->find($item['product_id'], ['price']);
            if (!$product) {
                throw new HttpResponseException(new JsonError(
                    sprintf('Product id %d is not found', $item['product_id'])
                ), 404);
            }
            $total += $product->price * $item['quantity'];
        }

        return $total;
    }

    public function place(Quote $quote)
    {
        $quote->total = $this->calculate($quote->products);

        return $this->save($quote);
    }
}
