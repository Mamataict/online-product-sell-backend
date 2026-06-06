<?php

namespace App\Traits;

use App\Models\Product\ProductInfo;
use App\Models\Product\ProductCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait ProductInfoCheck
{
    public function available_products()
    {

        $product_categories = ProductCategory::with(['products' => function ($query) {
            $query->has('latest_price')
                ->with(['complete_orders', 'latest_price'])
                ->where('is_active', 1)
                ->orderBy('view_order', 'asc');
        }])
            ->whereHas('products', function ($query) {
                $query->has('latest_price')
                    ->where('is_active', 1);
            })
            ->where('is_active', 1)
            ->orderBy('view_order', 'asc')
            ->get();

        // $product_categories->each(function ($category) {
        //     $category->products = $category->products
        //         ->filter(function ($product) {
        //             $complete_orders_qty = $product->complete_orders->sum('qty');
        //             return $product->stock > $complete_orders_qty;
        //         })
        //         ->values()
        //         ->map(function ($product) {
        //             $complete_orders_qty = $product->complete_orders->sum('qty');
        //             $product->available_qty = $product->stock - $complete_orders_qty;
        //             return $product;
        //         });
        // });

        


        // $products = ProductInfo::has('latest_price')->with([
        //     'complete_orders',
        //     'latest_price'
        // ])

        //     ->where('is_active', 1)
        //     ->get()

        //     ->filter(function ($product) {
        //         $complete_orders_qty = $product->complete_orders->sum('qty');
        //         return $product->stock > $complete_orders_qty;
        //     })
        //     ->values()
        //     ->map(function ($product) {
        //         $complete_orders_qty = $product->complete_orders->sum('qty');

        //         $product->available_qty = $product->stock - $complete_orders_qty;

        //         return $product;
        //     });
        return $product_categories;
    }
}
