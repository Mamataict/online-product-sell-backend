<?php

namespace App\Models\Order;

use App\Models\Product\ProductInfo;
use App\Models\Product\ProductPrices;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = [
        'order_id',
        'product_info_id',
        'price',
        'qty',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function product()
    {
        return $this->belongsTo(ProductInfo::class, 'product_info_id', 'id');
    }

    public function order_info(){
        return $this->belongsTo(OrderInfo::class, 'order_id');
    }

    public function adjustment()
    {
        return $this->hasOne(Adjustment::class, 'order_details_id');
    }
}
