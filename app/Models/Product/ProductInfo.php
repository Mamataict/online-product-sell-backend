<?php

namespace App\Models\Product;

use App\Models\Order\CartDetails;
use App\Models\Order\OrderDetails;
use App\Models\Order\OrderInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProductInfo extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'stock',
        'image',
        'product_category_id',
        'is_active',
    ];

    protected $appends = ['image_url'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function getImageUrlAttribute()
    {
        $image = $this->attributes['image'] ?? null;

        if ($image) {
            return url('storage/images/product/' . $image);
        }

        return url('images_cus/default_images/default.jpg');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrices::class, 'product_info_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderDetails::class, 'product_info_id');
    }

    public function complete_orders()
    {
        return $this->orders()->whereHas('order_info', function ($query) {
            $query->whereIn('status', [2, 3]);
        });
    }

    public function cart_items()
    {
        return $this->hasMany(CartDetails::class, 'product_info_id');
    }


    public function latest_price()
    {
        return $this->hasOne(ProductPrices::class, 'product_info_id')
            ->ofMany([
                'effect_date' => 'max',
                'id' => 'max'
            ], function ($query) {
                $query->where('effect_date', '<=', now())
                    ->where('is_active', 1);
            });
    }
}
