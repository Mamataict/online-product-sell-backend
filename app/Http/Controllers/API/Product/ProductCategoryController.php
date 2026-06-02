<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductCategoryRequest;
use App\Models\Product\ProductCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:product_category.index')->only(['index']);
        $this->middleware('check_permission:product_category.store')->only(['store']);
        $this->middleware('check_permission:product_category.show')->only(['show']);
        $this->middleware('check_permission:product_category.update')->only(['update']);
        $this->middleware('check_permission:product_category.destroy')->only('destroy');
        $this->middleware('check_permission:product_category.activation')->only('activation');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $product_category = ProductCategory::with('products')->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $product_category,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request): JsonResponse
    {
        try {
            $store_product_category = ProductCategory::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Info stored successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $product_category = ProductCategory::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Info retrieved successfully.',
                'data' => $product_category
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $product_category = ProductCategory::find($id);

            if (empty($product_category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            $product_category->name = $request->name;
            $product_category->is_active = $request->is_active;

            $product_category->save();

            return response()->json([
                'status' => true,
                'message' => 'Updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $product_category = ProductCategory::find($id);

            if (empty($product_category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            $product_category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Product category deleted successfully',
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
            $product_category = ProductCategory::find($id);

            if (empty($product_category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product category not found',
                ]);
            }

            $product_category->is_active = !$product_category->is_active;
            $product_category->save();

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
