<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Resources\ProductCollection;
use App\Http\Responses\JsonError;
use App\Http\Responses\JsonSuccess;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product as ProductResource;

/**
 * Class ProductController
 */
class ProductController extends Controller
{
    /** @var ProductService */
    protected $product;

    /**
     * ProductController constructor.
     *
     * @param ProductService $product
     */
    public function __construct(ProductService $product)
    {
        $this->product = $product;
    }

    /**
     * List all products.
     *
     * @return JsonResource
     */
    public function index()
    {
        return new ProductCollection($this->product->findAll());
    }

    /**
     * Create a new product.
     *
     * @param StoreProduct $request
     * @return JsonError|JsonSuccess
     */
    public function create(StoreProduct $request)
    {
        $product = $this->product->findByProperties(
            $request->json('type'),
            $request->json('color'),
            $request->json('size')
        );

        if ($product->count()) {
            return new JsonError('Product with given type, color and size already exists', 409);
        }

        $product = $this->product->createModel()->fill($request->all());

        if (!$this->product->save($product)) {
            return new JsonError('Error occurred while creating a new product', 500);
        }

        return new JsonSuccess(['payload' => new ProductResource($product)]);
    }
}
