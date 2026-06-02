<?php

namespace App\Models\Order;

use App\Models\Product\ProductInfo;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    protected $fillable = [
        'cart_id',
        'product_info_id',
        'qty',
        'price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductInfo::class, 'product_info_id');
    }
}
