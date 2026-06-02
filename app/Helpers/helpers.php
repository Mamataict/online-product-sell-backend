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
