<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreSupplierRequest;
use App\Http\Requests\Product\UpdateSupplierRequest;
use App\Models\Product\Supplier;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('check_permission:supplier.index')->only(['index']);
    //     $this->middleware('check_permission:supplier.store')->only(['store']);
    //     $this->middleware('check_permission:supplier.show')->only(['show']);
    //     $this->middleware('check_permission:supplier.update')->only(['update']);
    //     $this->middleware('check_permission:supplier.destroy')->only('destroy');
    //     $this->middleware('check_permission:supplier.activation')->only('activation');
    // }
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     try {
    //         $product_id = request('product_id');

    //         $query = Supplier::query();

    //         if ($search = request('search')) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('name', 'like', "%{$search}%")
    //                     ->orWhere('phone', 'like', "%{$search}%");
    //             });
    //         }

    //         if ($product_id) {
    //             $query->whereHas('product', function ($q) use ($product_id) {
    //                 $q->where('product_infos.id', $product_id);
    //             });
    //         }

    //         $suppliers = $query->orderByDesc('created_at')->paginate(10);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $suppliers,
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
    // public function store(StoreSupplierRequest $request)
    // {
    //     try {
    //         $store_supplier = Supplier::create([
    //             'name' => $request->name,
    //             'address' => $request->address,
    //             'phone' => $request->phone,
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
    //         $supplier = Supplier::find($id);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Info retrieved successfully.',
    //             'data' => $supplier,
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
    // public function update(UpdateSupplierRequest $request, string $id)
    // {
    //     try {
    //         $supplier = Supplier::find($id);

    //         if (empty($supplier)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Supplier not found',
    //             ], 404);
    //         }

    //         $supplier->name = $request->name;
    //         $supplier->address = $request->address;
    //         $supplier->phone = $request->phone;
    //         $supplier->is_active = $request->is_active;
    //         $supplier->save();

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
    //         $supplier = Supplier::find($id);

    //         if (empty($supplier)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $supplier->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Supplier deleted successfully',
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
    //         $supplier = Supplier::find($id);

    //         if (empty($supplier)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Product category not found',
    //             ]);
    //         }

    //         $supplier->is_active = !$supplier->is_active;
    //         $supplier->save();

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
