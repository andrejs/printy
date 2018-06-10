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
            ],
            [
                'name' => 'T shirt B',
                'type' => 't-shirt',
                'color' => 'green',
                'size' => 'M',
            ],
            [
                'name' => 'T shirt C',
                'type' => 't-shirt',
                'color' => 'yellow',
                'size' => 'XL',
            ],
            [
                'name' => 'Sneackers',
                'type' => 'shoes',
                'color' => 'black',
                'size' => '42',
            ],
        ];

        foreach ($data as $product) {
            Product::create($product);
        }
    }
}
