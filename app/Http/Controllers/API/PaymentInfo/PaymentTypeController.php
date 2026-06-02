<?php

namespace App\Http\Controllers\API\PaymentInfo;

use App\Http\Controllers\Controller;
use App\Models\Order\PaymentInfo\PaymentType;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{

    // public function index(): JsonResponse
    // {
    //     try {
    //         $payment_types = PaymentType::when(request('search'), function ($query) {
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

    // public function paymentTypes(): JsonResponse
    // {
    //     try {
    //         $payment_types = PaymentType::orderByDesc('created_at')
    //         ->get();

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

    // public function store(Request $request): JsonResponse
    // {
    //     try {
    //         $store_payment_type = PaymentType::create([
    //             'name' => $request->name,
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

    // public function show(string $id): JsonResponse
    // {
    //     try {
    //         $payment_type = PaymentType::find($id);

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

    // public function update(Request $request, string $id)
    // {
    //     try {
    //         $payment_type = PaymentType::find($id);

    //         if (empty($payment_type)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $payment_type->update([
    //             'name' => $request->name,
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

    // public function destroy(string $id): JsonResponse
    // {
    //     try {
    //         $payment_type = PaymentType::find($id);

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
    //         $payment_type = PaymentType::find($id);

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
