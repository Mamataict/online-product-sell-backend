<?php

namespace App\Models\Order;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    protected $fillable = [
        'amount',
        'reason',
        'type',
        'adjustment_date',
        'order_details_id',
        'created_by',
    ];

    public function orderDetails()
    {
        return $this->belongsTo(OrderDetails::class, 'order_details_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
