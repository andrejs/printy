<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\QuoteService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class QuoteServiceTest extends TestCase
{
    /**
     * @param array $productRequest
     * @param array $prices
     * @param int $expected
     * @dataProvider calculateDataProvider
     */
    public function testCalculate($productRequest, $prices, $expected)
    {
        /** @var QuoteService|MockObject $service */
        $service = $this->getMockBuilder(QuoteService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getProductPrices'])
            ->getMock();

        $service
            ->expects($this->once())
            ->method('getProductPrices')
            ->willReturn($prices);

        $this->assertEquals($expected, $service->calculate($productRequest));
    }

    /**
     * @return array
     */
    public function calculateDataProvider()
    {
        return [
            [
                [
                    [
                        'product_id' => 1,
                        'quantity' => 5,
                    ],
                    [
                        'product_id' => 3,
                        'quantity' => 3,
                    ],
                    [
                        'product_id' => 7,
                        'quantity' => 9,
                    ],
                ],
                [
                    $this->makeProductPrice(1, 2300),
                    $this->makeProductPrice(3, 1250),
                    $this->makeProductPrice(7, 2599),
                ],
                38641,
            ]
        ];
    }

    protected function makeProductPrice($id, $price)
    {
        $product = new Product(['price' => $price]);
        $product->id = $id;

        return $product;
    }
}
