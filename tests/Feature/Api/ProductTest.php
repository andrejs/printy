<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/api/product';

    public function testProductList()
    {
        factory(Product::class)->create();

        $response = $this->get($this->endpoint);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'type',
                        'color',
                        'size',
                        'price',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function testAddProduct()
    {
        $data = factory(Product::class)->raw();

        $response = $this->postJson($this->endpoint, $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function testAddProductWithFailedValidation()
    {
        $data = factory(Product::class)->raw();
        unset($data['price']);

        $response = $this->postJson($this->endpoint, $data);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testAddProductConstraintViolation()
    {
        $data = factory(Product::class)->raw();

        $response = $this->postJson($this->endpoint, $data);
        $response
            ->assertStatus(200);

        $response = $this->postJson($this->endpoint, $data);
        $response
            ->assertStatus(409)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'Product with given type, color and size already exists'
                ],
            ]);
    }
}
