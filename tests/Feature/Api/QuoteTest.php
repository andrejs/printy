<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuoteTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/api/quote';

    public function setUp()
    {
        parent::setUp();

        config(['custom.geocoder.enabled' => false]);
    }

    public function testCreateQuote()
    {
        $products = factory(Product::class, 2)->create();

        $response = $this->post($this->endpoint, $this->generateRequestData($products));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'payload',
            ]);
    }

    public function testCreateQuoteNonExistantProduct()
    {
        $product = factory(Product::class)->make();
        $product->id = 9999;

        $response = $this->post($this->endpoint, $this->generateRequestData([$product]));

        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testRateLimit()
    {
        config(['custom.rate_limiter.limit' => 1]);
        config(['custom.rate_limiter.period' => 1]);

        $products = factory(Product::class, 2)->create();

        $response = $this->post($this->endpoint, $this->generateRequestData($products));
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $response = $this->post($this->endpoint, $this->generateRequestData($products));
        $response
            ->assertStatus(429)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testMinOrderPrice()
    {
        config(['custom.quote.min_order_price' => 100000000]);

        $product = factory(Product::class)->create();

        $response = $this->post($this->endpoint, $this->generateRequestData([$product]));
        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testEmptyPayload()
    {
        $response = $this->post($this->endpoint, []);
        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testListQuoteByType()
    {
        config(['custom.rate_limiter.limit' => 10]);
        config(['custom.rate_limiter.period' => 1]);

        $product = factory(Product::class)->create(['type' => 'hat']);

        $response = $this->post($this->endpoint, $this->generateRequestData([$product]));
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $products = factory(Product::class, 2)->create();

        $response = $this->post($this->endpoint, $this->generateRequestData($products));
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $response = $this->get($this->endpoint . '/hat');
        $response
            ->assertStatus(200)
            ->assertJson([
                [
                    'products' => [
                        [
                            'id' => $product->id,
                        ]
                    ]
                ]
            ]);
    }

    private function generateRequestData($products)
    {
        $data = ['products' => []];

        foreach ($products as $product) {
            $data['products'][] = [
                'product_id' => $product->id,
                'quantity' => mt_rand(1, 10),
            ];
        }

        return $data;
    }
}
