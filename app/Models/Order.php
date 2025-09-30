<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_price', 'status'
    ];

    public function cartItems()
    {
        // Assuming each order has many cart items
        return $this->hasMany(Cart::class, 'order_id');
    }
}
