<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
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
              'category_name' => "boots",
            ],
            [
                'category_id'   => 2,
                'category_name' => "sandals",
            ],
            [
                'category_id'     => 3,
                'category_name'   => "sneakers",
            ]
        ];

        Category::insert($rowData);
    }
}
