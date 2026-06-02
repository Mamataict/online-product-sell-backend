<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Override;

class Cart extends Model
{
    protected $fillable = [
        'guest_id'
    ];

    public function cart_details()
    {
        return $this->hasMany(CartDetails::class, 'cart_id');
    }
}
