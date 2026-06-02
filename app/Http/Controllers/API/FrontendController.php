<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order\Cart;
use App\Models\Order\Customer;
use App\Models\Order\OrderInfo;
use App\Models\Product\ProductInfo;
use App\Models\Product\ProductPrices;
use App\Models\Order\DeliveryFee;
use App\Traits\ProductInfoCheck;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    use ProductInfoCheck;
    public function __construct()
    {
        // $this->middleware('check_permission:dasboard.info')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $products = $this->available_products();

            $delivery_fee = DeliveryFee::where('is_active', 1)->whereDate('effect_date', '<=', Carbon::today())->get();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'products' => $products,
                    'delivery_fee' => $delivery_fee,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
            ], 500);
        }
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
