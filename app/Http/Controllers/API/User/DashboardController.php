<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Order\Customer;
use Illuminate\Http\Request;
use App\Models\Order\OrderInfo;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_orders = OrderInfo::count();
        $total_pending = OrderInfo::where('status', 1)->count();
        $total_confirmed = OrderInfo::where('status', 2)->count();
        $total_delivered = OrderInfo::where('status', 3)->count();
        $total_cancelled = OrderInfo::where('status', 4)->count();
        $total_paid = OrderInfo::whereIn('status', [2, 3])->sum('grand_total');
    
        try {
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'total_orders' => $total_orders,
                    'total_pending' => $total_pending,
                    'total_confirmed' => $total_confirmed,
                    'total_delivered' => $total_delivered,
                    'total_cancelled' => $total_cancelled,
                    'total_paid' => $total_paid,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
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
