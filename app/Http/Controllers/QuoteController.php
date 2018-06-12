<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateQuote;
use App\Http\Responses\JsonError;
use App\Http\Responses\JsonSuccess;
use App\Services\ProductQuoteService;
use App\Services\QuoteService;
use App\Http\Resources\Quote as QuoteResource;

class QuoteController extends Controller
{
    /** @var QuoteService */
    protected $quote;

    /** @var ProductQuoteService */
    protected $productQuote;

    /**
     * QuoteController constructor.
     *
     * @param QuoteService $quote
     * @param ProductQuoteService $productQuoteService
     */
    public function __construct(QuoteService $quote, ProductQuoteService $productQuoteService)
    {
        $this->quote = $quote;
        $this->productQuote = $productQuoteService;
    }

    /**
     * List all quotes.
     *
     * @return array
     */
    public function index()
    {
        return $this->quote->findAll();
    }

    /**
     * Calculate and store a new Quote.
     *
     * @param CalculateQuote $request
     * @return JsonError|JsonSuccess
     */
    public function calculate(CalculateQuote $request)
    {
        $quote = $this->quote->createModel();
        $products = $request->get('products');

        $this->quote->place($quote, $products);

        $products = $this->productQuote->findByQuote($quote);

        return new JsonSuccess(['payload' => new QuoteResource($quote, $products)]);
    }
}
