<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_movement extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'note',
        'user_id'
    ];
}
