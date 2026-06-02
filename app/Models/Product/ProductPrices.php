<?php

namespace App\Models\Product;

use App\Models\Branch\BranchInfo;
use App\Models\Campaign\CampaignDetails;
use App\Models\Order\OrderDetails;
use Illuminate\Database\Eloquent\Model;

class ProductPrices extends Model
{
    protected $fillable = [
        'unit',
        'product_info_id',
        'branch_info_id',
        'price',
        'discount_type',
        'discount',
        'effect_date',
        'is_active',
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
        return $this->belongsTo(ProductInfo::class, 'product_info_id');
    }

}
