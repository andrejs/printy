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
    const MIN_ORDER_PRICE = 10;

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

    /**
     * Calculate quote price base on passed $products data.
     *
     * @param array $products contains references to products and their quantities
     * @return int calculated total price
     * @throws HttpResponseException
     */
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

    /**
     * Place a new quote.
     *
     * Calculates total price and saves to database.
     *
     * @param Quote $quote
     * @return bool
     */
    public function place(Quote $quote)
    {
        $quote->total = $this->calculate($quote->products);

        $minOrderPrice = $this->getMinOrderPrice();
        if ($quote->total < $minOrderPrice) {
            throw new HttpResponseException(new JsonError(sprintf(
                'Quote total price %d is below minimum of %d',
                $quote->total,
                $minOrderPrice
            )), 400);
        }

        return $this->save($quote);
    }

    /**
     * Get minimum order price.
     *
     * @return int
     */
    protected function getMinOrderPrice()
    {
        return static::MIN_ORDER_PRICE;
    }
}
