<?php

namespace App\Http\Controllers\API\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\StoreBranchStoreRequest;
use App\Http\Requests\Branch\UpdateBranchStoreRequest;
use App\Models\Branch\BranchInfo;
use App\Models\Branch\Store;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('check_permission:branch.store.index')->only(['index']);
    //     $this->middleware('check_permission:branch.store.store')->only(['store']);
    //     $this->middleware('check_permission:branch.store.show')->only(['show']);
    //     $this->middleware('check_permission:branch.store.update')->only(['update']);
    //     $this->middleware('check_permission:branch.store.destroy')->only('destroy');
    //     $this->middleware('check_permission:branch.store.activation')->only('activation');
    // }

    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(): JsonResponse
    // {
    //     try {
    //         $stores = Store::with('branchInfo')
    //             ->when(request('search'), function ($query) {
    //                 $query->where('name', 'like', '%' . request('search') . '%');
    //             })
    //             ->orderByDesc('created_at')
    //             ->paginate(10);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $stores,
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ], 500);
    //     }
    // }

    // public function create(): JsonResponse
    // {
    //     try {
    //         $branches = BranchInfo::active()->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => [
    //                 'branches' => $branches,
    //             ],
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
    // public function store(StoreBranchStoreRequest $request): JsonResponse
    // {
    //     try {
    //         Store::create([
    //             'branch_info_id' => $request->branch_info_id,
    //             'name' => $request->name,
    //             'store_code' => $request->store_code,
    //             'is_active' => $request->is_active,
    //         ]);
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Store created successfully.',
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
    // public function show(string $id)
    // {
    //     try {
    //         $branches = BranchInfo::active()->get();
    //         $store = Store::with('branchInfo')->find($id);

    //         if (empty($store)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Info retrieved successfully.',
    //             'data' => [
    //                 'store' => $store,
    //                 'branches' => $branches,
    //             ],
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
    // public function update(UpdateBranchStoreRequest $request, string $id)
    // {
    //     try {
    //         $branch_store = Store::find($id);

    //         if (empty($branch_store)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $branch_store->branch_info_id = $request->branch_info_id;
    //         $branch_store->name = $request->name;
    //         $branch_store->store_code = $request->store_code;
    //         $branch_store->is_active = $request->is_active;
    //         $branch_store->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Store updated successfully.',
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
    //         $branch_store = Store::find($id);

    //         if (empty($branch_store)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $branch_store->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Branch Store deleted successfully',
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
    //         $branch_store = Store::find($id);

    //         if (empty($branch_store)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ]);
    //         }

    //         $branch_store->is_active = !$branch_store->is_active;
    //         $branch_store->save();

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
