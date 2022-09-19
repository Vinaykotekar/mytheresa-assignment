<?php

namespace Database\Seeders;

use App\Models\SKUDiscountRules;
use Illuminate\Database\Seeder;

class DiscountRulesBySkuSeeder extends Seeder
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
              'sku'   => '000003',
              'discount_percentage' => 15,
            ]
        ];

        SKUDiscountRules::insert($rowData);
    }
}
