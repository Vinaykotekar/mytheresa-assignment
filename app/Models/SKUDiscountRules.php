<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUDiscountRules extends Model
{
    use HasFactory;

    protected $table = 'discount_rules_by_sku';
    protected $primaryKey = NULL;
    public $incrementing = false;
    public $timestamps = false;
}
