<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Checks product listing HTTP status.
     *
     * @return void
     */
    public function test_product_list()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/products');
        $response->assertStatus(200);
    }

    /**
     * Checks product pagination structure.
     *
     * @return void
     */
    public function test_paginator_structure()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'sku',
                        'name',
                        'category',
                        'price'=> [
                            'original',
                            'final',
                            'discount_percentage',
                            'currency',
                        ]
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
          ]);
    }

    /**
     * Checks product category id filter.
     *
     * @return void
     */
    public function test_category_id_filter_working_correct() {
        $response = $this->get('/api/products?category_id=1');
        $json = $response->json();
        $items = $json['data'];

        foreach ($items as $item){
            $this->assertEquals(1, $item['category_id']);
        }
    }

    /**
     * Checks product category name filter.
     *
     * @return void
     */
    public function test_category_name_filter_working_correct() {
        $response = $this->get('/api/products?category=boots');
        $json = $response->json();
        $items = $json['data'];

        foreach ($items as $item){
            $this->assertEquals('boots', $item['category']);
        }
    }

    /**
     * Checks max price filter.
     *
     * @return void
     */
    public function test_max_price_filter_working_correct() {
        $response = $this->get('/api/products?priceLessThan=59000');
        $json = $response->json();
        $items = $json['data'];

        foreach ($items as $item){
            $this->assertLessThanOrEqual(59000, $item['price']['original']);
        }
    }

    /**
     * Checks original price is same as final price when no discount.
     *
     * @return void
     */
    public function test_original_and_final_price_match_if_no_discount() {
        $response = $this->get('/api/products');
        $json = $response->json();
        $items = $json['data'];

        foreach ($items as $item){
            if(is_null($item['price']['discount_percentage'])){
                $this->assertEquals($item['price']['original'], $item['price']['final']);
            }
        }
    }

    /**
     * Checks final price is according to applicable discount.
     *
     * @return void
     */
    public function test_final_price_ok_if_discount_is_there() {
        $response = $this->get('/api/products');
        $json = $response->json();
        $items = $json['data'];

        foreach ($items as $item){
            if(!is_null($item['price']['discount_percentage'])){
                //parse int value (x) from x%
                $discount = floatval($item['price']['discount_percentage']);
                $caldiscount = $item['price']['original']*$discount/100;
                $calfinal = intval( round( $item['price']['original']-$caldiscount) );
                $this->assertEquals($calfinal, $item['price']['final']);
            }
        }
    }

    /**
     * Checks currency is EUR.
     *
     * @return void
     */
    public function test_currency_always_euro() {
        $response = $this->get('/api/products');
        $json = $response->json();
        $items = $json['data'];

        foreach ($items as $item){
            $this->assertEquals("EUR", $item['price']['currency']);
        }
    }
}
