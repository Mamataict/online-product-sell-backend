<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class DuePayment extends Model
{
    protected $fillable = [
        'order_info_id',
        'due_paid_amount',
        'due_paid_date',
        'remark',
        'pay_via'
    ];

    public function order()
    {
        return $this->belongsTo(OrderInfo::class);
    }

    // public function due_paid_via()
    // {
    //     return $this->belongsTo(PaymentVia::class, 'due_payment_via_id');
    // }
}
