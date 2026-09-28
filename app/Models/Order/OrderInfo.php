<?php

namespace App\Models\Order;

use App\Models\Branch\BranchInfo;
use App\Models\Campaign\CampaignDetails;
use App\Models\PaymentInfo\PaymentVia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $fillable = [
        'order_info_id',
        'customer_id',
        'subtotal',
        'grand_total',
        'delivery_fee',
        'status',
        'payment_status',
        'place_date',
        'handler_id',
        'remark',
        'remark_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    protected $appends = ['status_text', 'payment_status_text'];

    public function getStatusTextAttribute()
    {
        return orderStatus($this->status);
    }

    public function getPaymentStatusTextAttribute()
    {
        return orderPaymentStatus($this->payment_status);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function orders()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handler_id');
    }
    public function remarker()
    {
        return $this->belongsTo(User::class, 'remark_by');
    }

    public static function generateOrderId(): string
    {
        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');

        $count = self::whereYear('place_date', $year)
                     ->whereMonth('place_date', $month)
                     ->count();

        $serial = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "{$year}{$month}{$serial}";
    }
}
