<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('hasPermission')) {
    function hasPermission($permission): bool
    {
        return Auth::guard('api')->check() && Auth::guard('api')->user()->hasPermission($permission);
    }
}

if (! function_exists('discountedPrice')) {
    function discountedPrice($order)
    {
        $discountedPrice = 0;
        $total_price = 0;

        if ($order->campaign) {
            foreach ($order->orders as $item) {
                $total_price += $item->price;
            }

            $total_price += $order->delivery_fee;

            if ($order->campaign->discount_type === 'percentage') {
                $discountedPrice = ( $order->campaign->discount * $total_price) / 100;
            } else {
                $discountedPrice = $order->campaign->discount;
            }

        }

        return $discountedPrice;
    }
}

if (! function_exists('orderStatus')) {
    function orderStatus(int $order_status)
    {
        switch ($order_status) {
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
}

if (! function_exists('paymentStatus')) {
    function orderPaymentStatus(int $payment_status)
    {
        switch ($payment_status) {
            case 1:
                return 'Due';
            case 2:
                return 'Paid';
            default:
                return 'Unknown';
        }
    }
}
