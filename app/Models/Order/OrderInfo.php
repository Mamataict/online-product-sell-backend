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
        'place_date',
        'handler_id',
        'remark',
        'remark_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    protected $appends = ['status_text'];

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Confirmed';
            case 3:
                return 'Delivered';
            case 4:
                return 'Cancelled';
            default:
                return 'Unknown';
        }
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
