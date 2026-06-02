<?php

namespace App\Http\Controllers\API\PaymentInfo;

use App\Http\Controllers\Controller;
use App\Models\PaymentInfo\PaymentVia;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentViaController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(): JsonResponse
    // {
    //     try {
    //         $payment_types = PaymentVia::with('payment_type')->when(request('search'), function ($query) {
    //             $query->where('name', 'like', '%' . request('search') . '%');
    //         })
    //         ->orderByDesc('created_at')
    //         ->paginate(10);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $payment_types,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ], 500);
    //     }
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request): JsonResponse
    // {
    //     try {
    //         $store_payment_type = PaymentVia::create([
    //             'name' => $request->name,
    //             'payment_type_id' => $request->selectedTypeId,
    //             'is_active' => $request->is_active,
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Info stored successfully.',
    //             'data' => [],
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ], 500);
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id): JsonResponse
    // {
    //     try {
    //         $payment_type = PaymentVia::find($id);

    //         if (empty($payment_type)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $payment_type,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ], 500);
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     try {
    //         $payment_type = PaymentVia::find($id);

    //         if (empty($payment_type)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $payment_type->update([
    //             'name' => $request->name,
    //             'payment_type_id' => $request->payment_type_id,
    //             'is_active' => $request->is_active,
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Info updated successfully.',
    //             'data' => [],
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ], 500);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id): JsonResponse
    // {
    //     try {
    //         $payment_type = PaymentVia::find($id);

    //         if (empty($payment_type)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $payment_type->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Payment type deleted successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ]);
    //     }
    // }

    // public function activation(string $id): JsonResponse
    // {
    //     try {
    //         $payment_type = PaymentVia::find($id);

    //         if (empty($payment_type)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Payment type not found',
    //             ]);
    //         }

    //         $payment_type->is_active = !$payment_type->is_active;
    //         $payment_type->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Status updated successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }
}
