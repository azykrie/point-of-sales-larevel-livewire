<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale_item extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];
}
