<?php

namespace App\Http\Controllers;

use App\Models\Order\DeliveryFee;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ProductInfoCheck;

class FrontendController extends Controller
{
    use ProductInfoCheck;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $product_categories = $this->available_products();

            $products = $product_categories->flatMap->products->values();

            $products_view = $product_categories->flatMap(function ($category) {
                return $category->products->take(1);
            })->values();

            $delivery_fee = DeliveryFee::where('is_active', 1)->whereDate('effect_date', '<=', Carbon::today())->get();
            
            $data = [
                    'products_view' => $products_view,
                    'products' => $products,
                    'delivery_fee' => $delivery_fee,
            ];

            return view('welcome', compact('data'));
              
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
