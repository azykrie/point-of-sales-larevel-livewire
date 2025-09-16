<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'payment_method',
        'total_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke item penjualan
    public function items()
    {
        return $this->hasMany(Sale_item::class);
    }
}
