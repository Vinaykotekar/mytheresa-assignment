<?php

namespace Database\Seeders;

use App\Models\CategoryDiscountRules;
use Illuminate\Database\Seeder;

class DiscountRulesByCategorySeeder extends Seeder
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
              'category_id'   => 1,
              'discount_percentage' => 30,
            ]
        ];

        CategoryDiscountRules::insert($rowData);
    }
}
