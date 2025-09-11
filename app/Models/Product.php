<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'purchase_price',
        'selling_price',
        'stock',
        'category_id'
    ];

    protected $attributes = [
        'purchase_price' => 0,
        'selling_price' => 0,
        'stock' => 0,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
