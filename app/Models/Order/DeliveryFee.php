<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model
{
    protected $fillable = [
        'info',
        'delivery_charge',
        'effect_date',
        'is_active',
    ];
}
