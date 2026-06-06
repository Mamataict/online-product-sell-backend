<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Branch\BranchInfo;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductInfo;
use App\Models\Product\Supplier;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\json;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:product.index')->only(['index']);
        $this->middleware('check_permission:product.store')->only(['store']);
        $this->middleware('check_permission:product.show')->only(['show']);
        $this->middleware('check_permission:product.update')->only(['update']);
        $this->middleware('check_permission:product.destroy')->only('destroy');
        $this->middleware('check_permission:product.activation')->only('activation');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $category_id = request('category_id');

            $query = ProductInfo::with(['prices', 'category'])
                ->when(request('search'), function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })
                ->orderByDesc('created_at');

            if ($category_id) {
                $query->whereHas('category', fn($q) => $q->where('id', $category_id));
            }

            $product = $query->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $product,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function create(): JsonResponse
    {
        try {
            $product_categories = ProductCategory::active()->get();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'product_categories' => $product_categories,
                ],
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
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $store_product = ProductInfo::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'instruction' => $request->instruction,
                'view_order' => $request->view_order,
                'product_category_id' => $request->product_category_id,
                'is_active' => $request->is_active,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = (new DateTime())->format('YmdHisu') . '.' . $image->extension();
                $image->storeAs('images/product', $imageName, 'public');
                $store_product->image = $imageName;
                $store_product->save();
            }

            if (!empty($request->prices)) {
                foreach ($request->prices as $priceData) {
                    $productPrice = $store_product->prices()->create([
                        'price' => $priceData['price'],
                        'effect_date' => $priceData['effect_date'],
                        'is_active' => $priceData['is_active'] == 'true' ? true : false,
                    ]);
                }
            }

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
            $product_categories = ProductCategory::active()->get();
            $product = ProductInfo::with(['category', 'prices'])->find($id);

            return response()->json([
                'status' => true,
                'message' => 'Info retrieved successfully.',
                'data' => [
                    'product' => $product,
                    'product_categories' => $product_categories,
                ],
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
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        try {

            $product = ProductInfo::find($id);

            $product->name = $request->name;
            $product->unit = $request->unit;
            $product->instruction = $request->instruction;
            $product->view_order = $request->view_order;
            $product->product_category_id = $request->product_category_id;
            $product->is_active = $request->is_active;

            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists('images/product/' . $product->image)) {
                    Storage::disk('public')->delete('images/product/' . $product->image);
                }
                $image = $request->file('image');
                $imageName = (new DateTime())->format('YmdHisu') . '.' . $image->extension();
                $image->storeAs('images/product', $imageName, 'public');
                $product->image = $imageName;
            }

            $product->save();

            if (!empty($request->delete_ids)) {
                foreach ($request->delete_ids as $delId) {
                    $productPrice = $product->prices()->find($delId);

                    if ($productPrice) {
                        $productPrice->delete();
                    }
                }
            }

            foreach ($request->prices as $priceData) {
                $productPrice = $product->prices()->updateOrCreate(
                    ['id' => $priceData['price_id'] ?? null],
                    [
                        'price' => $priceData['price'],
                        'effect_date' => $priceData['effect_date'],
                        'is_active' => $priceData['is_active'] == 'true' ? true : false,
                    ]
                );
            }

            return response()->json([
                'status' => true,
                'message' => 'Product info updated successfully',
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
            $product = ProductInfo::find($id);

            if (empty($product)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            $product->delete();

            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully',
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
            $product = ProductInfo::find($id);

            if (empty($product)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found',
                ]);
            }

            $product->is_active = !$product->is_active;
            $product->save();

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
