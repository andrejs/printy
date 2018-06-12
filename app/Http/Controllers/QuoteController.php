<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteCollection;
use App\Services\QuoteService;
use Illuminate\Http\Resources\Json\JsonResource;

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
}
