<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rowData = [
            [
                'product_id'  => 1,
                'sku'         => "000001",
                'category_id' => 1,
                'price'       => 89000,
                'name'        => "BV Lean leather ankle boots",

            ],
            [
                'product_id'  => 2,
                'sku'         => "000002",
                'category_id' => 1,
                'price'       => 99000,
                'name'        => "BV Lean leather ankle boots",
            ],
            [
                'product_id'  => 3,
                'sku'         => "000003",
                'category_id' => 1,
                'price'       => 71000,
                'name'        => "Ashlington leather ankle boots",
            ],
            [
                'product_id'  => 4,
               'sku'         => "000004",
               'category_id' => 2,
               'price'       => 79500,
               'name'        => "Naima embellished suede sandals",
            ],
            [
                'product_id'  => 5,
                'sku'         => "000005",
                'category_id' => 3,
                'price'       => 59000,
                'name'        => "Nathane leather sneakers",
            ],
        ];

        Product::insert($rowData);
    }
}
