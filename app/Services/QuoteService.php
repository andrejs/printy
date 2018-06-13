<?php

namespace App\Services;

use App\Http\Responses\JsonError;
use App\Models\Quote;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class QuoteService
 */
class QuoteService extends AbstractService
{
    const MIN_ORDER_PRICE = 10;

    /** @var ProductService */
    protected $product;

    /** @var ProductQuoteService */
    protected $productQuote;

    /** @var GeocoderService */
    protected $geocoder;

    /**
     * QuoteService constructor.
     * @param ProductService $productService
     * @param ProductQuoteService $productQuoteService
     * @param GeocoderService $geocoderService
     */
    public function __construct(
        ProductService $productService,
        ProductQuoteService $productQuoteService,
        GeocoderService $geocoderService
    ) {
        $this->product = $productService;
        $this->productQuote = $productQuoteService;
        $this->geocoder = $geocoderService;
    }

    /**
     * Find all Quotes.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        return Quote::query()->with('products')->get();
    }

    /**
     * @param string $productType
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByProductType($productType)
    {
        return Quote::whereHas('products', function ($query) use ($productType) {
            $query->where(['type' => $productType]);
        })->with('products')->get();
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
                ), Response::HTTP_NOT_FOUND);
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
     * @param array $products
     * @throws HttpResponseException
     */
    public function place(Quote $quote, array $products)
    {
        DB::transaction(function () use ($quote, $products) {
            $quote->total = $this->calculate($products);
            $quote->country = $this->geocoder->resolveCountryCode();

            if ($this->isCountryLimitExceeded($quote)) {
                throw new HttpResponseException(new JsonError(sprintf(
                    'Quote limit from %s is exceeded. Please try again later.',
                    $quote->country
                )), Response::HTTP_TOO_MANY_REQUESTS);
            }

            $minOrderPrice = $this->getMinOrderPrice();
            if ($quote->total < $minOrderPrice) {
                throw new HttpResponseException(new JsonError(sprintf(
                    'Quote total price %d is below minimum of %d',
                    $quote->total,
                    $minOrderPrice
                )), Response::HTTP_BAD_REQUEST);
            }

            if (!$this->save($quote)) {
                throw new HttpResponseException(
                    new JsonError('Error occurred while creating a new quote')
                );
            };

            $this->productQuote->saveProductsForQuote($quote, $products);
        });
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

    /**
     * @param Quote $quote
     * @return bool
     */
    protected function isCountryLimitExceeded(Quote $quote)
    {
        $key = 'quote-country-rate-limit';
        $limit = config('custom.rate_limiter.limit', 1);
        $period = config('custom.rate_limiter.period', 1);

        if (Cache::has($key) && Cache::get($key) >= $limit) {
            return true;
        }

        Cache::increment($key, $period);

        return false;
    }
}
