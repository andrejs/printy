<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'T shirt A',
                'type' => 't-shirt',
                'color' => 'white',
                'size' => 'L',
                'price' => 500,
            ],
            [
                'name' => 'T shirt B',
                'type' => 't-shirt',
                'color' => 'green',
                'size' => 'M',
                'price' => 400,
            ],
            [
                'name' => 'T shirt C',
                'type' => 't-shirt',
                'color' => 'yellow',
                'size' => 'XL',
                'price' => 250,
            ],
            [
                'name' => 'Sneackers',
                'type' => 'shoes',
                'color' => 'black',
                'size' => '42',
                'price' => 1500,
            ],
            [
                'name' => 'Primark Hoodie',
                'type' => 'hoodie',
                'color' => 'gray',
                'size' => 'L',
                'price' => 1200,
            ],
        ];

        foreach ($data as $product) {
            Product::create($product);
        }
    }
}
