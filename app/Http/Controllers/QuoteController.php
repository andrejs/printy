<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateQuote;
use App\Http\Resources\QuoteCollection;
use App\Http\Responses\JsonError;
use App\Http\Responses\JsonSuccess;
use App\Services\QuoteService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Quote as QuoteResource;

class QuoteController extends Controller
{
    /** @var QuoteService */
    protected $quote;

    /**
     * QuoteController constructor.
     *
     * @param QuoteService $quote
     */
    public function __construct(QuoteService $quote)
    {
        $this->quote = $quote;
    }

    /**
     * List all quotes.
     *
     * @return JsonResource
     */
    public function index()
    {
        return new QuoteCollection($this->quote->findAll());
    }

    /**
     * Calculate and store a new Quote.
     *
     * @param CalculateQuote $request
     * @return JsonError|JsonSuccess
     */
    public function calculate(CalculateQuote $request)
    {
        $quote = $this->quote->createModel()->fill($request->all());

        if (!$this->quote->place($quote)) {
            return new JsonError('Error occurred while creating a new quote', 500);
        }

        return new JsonSuccess(['payload' => new QuoteResource($quote)]);
    }
}
