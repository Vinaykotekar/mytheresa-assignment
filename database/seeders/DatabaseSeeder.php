<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(DiscountRulesBySkuSeeder::class);
        $this->call(DiscountRulesByCategorySeeder::class);
    }
}
