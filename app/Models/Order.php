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
        // Fetch all cart items associated with the user who placed this order
        return $this->hasMany(Cart::class, 'user_id', 'user_id');  // Fixed to use 'user_id' instead of 'order_id'
    }


    // app/Models/Order.php

    public function user()
    {
        return $this->belongsTo(User::class);  // Make sure this is defined
    }    

}
