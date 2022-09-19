<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDiscountRules extends Model
{
    use HasFactory;

    protected $table = 'discount_rules_by_category';
    protected $primaryKey = NULL;
    public $incrementing = false;
    public $timestamps = false;
}
