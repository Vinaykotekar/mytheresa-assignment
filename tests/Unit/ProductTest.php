<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Mytheresa\DiscountHelper;

class ProductTest extends TestCase
{
    /**
     * Checks discount formula
     *
     * @return void
     */
    public function test_discount_formula() {
        $value = DiscountHelper::calcDiscounted(1000, 50);
        $this->assertEquals(500, $value);
    }
}
