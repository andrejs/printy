<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** @var ProductService */
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductService $product)
    {
        $this->product = $product;
    }

    /**
     * List all products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->product->findAll();
    }
}
