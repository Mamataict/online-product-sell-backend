<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\DeliveryFee;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:delivery_fee.index')->only(['index']);
        $this->middleware('check_permission:delivery_fee.store')->only(['store']);
        $this->middleware('check_permission:delivery_fee.show')->only(['show']);
        $this->middleware('check_permission:delivery_fee.update')->only(['update']);
        $this->middleware('check_permission:delivery_fee.destroy')->only('destroy');
        $this->middleware('check_permission:delivery_fee.activation')->only('activation');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $delivery_fees = DeliveryFee::when(request('search'), function ($query) {
                $query->where('info', 'like', '%' . request('search') . '%');
            })->orderByDesc('effect_date')->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $delivery_fees,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DeliveryFee::create([
                'info' => $request->info,
                'delivery_charge' => $request->delivery_charge,
                'effect_date' => $request->effect_date,
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Info stored successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $delivery_fee = DeliveryFee::find($id);

            return response()->json([
                'status' => true,
                'message' => 'Info retrieved successfully.',
                'data' => $delivery_fee,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {

            $delivery_fee = DeliveryFee::find($id);

            $delivery_fee->info = $request->info;
            $delivery_fee->delivery_charge = $request->delivery_charge;
            $delivery_fee->effect_date = $request->effect_date;
            $delivery_fee->is_active = $request->is_active;
            $delivery_fee->save();

            return response()->json([
                'status' => true,
                'message' => 'Info updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $delivery_fee = DeliveryFee::find($id);

            if (empty($delivery_fee)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            $delivery_fee->delete();

            return response()->json([
                'status' => true,
                'message' => 'Info deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }

    public function activation(string $id): JsonResponse
    {
        try {
            $delivery_fee = DeliveryFee::find($id);

            if (empty($delivery_fee)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found',
                ]);
            }

            $delivery_fee->is_active = !$delivery_fee->is_active;
            $delivery_fee->save();

            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }
}
