<?php

namespace App\Http\Controllers\API\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\BranchStoreRequest;
use App\Http\Requests\Branch\BranchUpdateRequest;
use App\Models\Branch\BranchInfo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('check_permission:branch.index')->only(['index']);
    //     $this->middleware('check_permission:branch.store')->only(['store']);
    //     $this->middleware('check_permission:branch.show')->only(['show']);
    //     $this->middleware('check_permission:branch.update')->only(['update']);
    //     $this->middleware('check_permission:branch.destroy')->only('destroy');
    //     $this->middleware('check_permission:branch.activation')->only('activation');
    //     $this->middleware('check_permission:branch.campaign.assign')->only('campaignAssign');
    // }
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(): JsonResponse
    // {
    //     try {
    //         $campaignDetailsId = request('campaign_details_id');
    //         $userId = request('user_id');

    //         $branches = BranchInfo::with([
    //                 'campaignDetails' => function ($q) use ($campaignDetailsId) {
    //                     if ($campaignDetailsId) {
    //                         return $q->where('campaign_details.id', $campaignDetailsId);
    //                     }
    //                 },
    //                 'users' => function ($q) use ($userId) {
    //                     if ($userId) {
    //                         return $q->where('users.id', $userId);
    //                     }
    //                 }
    //             ])
    //             ->when(request('search'), function ($query) {
    //                 $query->where('name', 'like', '%' . request('search') . '%');
    //             })

    //             ->withCount([
    //                 'campaignDetails as match_count' => function ($q) use ($campaignDetailsId) {
    //                     if($campaignDetailsId) {
    //                         $q->where('campaign_details.id', $campaignDetailsId);
    //                     }
    //                 }
    //             ])

    //             ->withCount([
    //                 'users as match_count' => function ($q) use ($userId) {
    //                     if($userId) {
    //                         $q->where('users.id', $userId);
    //                     }
    //                 }
    //             ])

    //             ->orderByDesc('match_count')

    //             ->orderByDesc('created_at')

    //             ->paginate(10);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $branches,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(BranchStoreRequest $request): JsonResponse
    // {
    //     try {
    //         $store_branch = BranchInfo::create([
    //             'name' => $request->name,
    //             'branch_code' => $request->branch_code,
    //             'address' => $request->address,
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
    // public function show(string $id)
    // {
    //     try {
    //         $branch = BranchInfo::find($id);

    //         if (empty($branch)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Info retrieved successfully.',
    //             'data' => $branch,
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
    // public function update(BranchUpdateRequest $request, string $id)
    // {
    //     try {
    //         $branch = BranchInfo::find($id);

    //         if (empty($branch)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $branch->name = $request->name;
    //         $branch->branch_code = $request->branch_code;
    //         $branch->address = $request->address;
    //         $branch->is_active = $request->is_active;
    //         $branch->save();

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
    //         $branch = BranchInfo::find($id);

    //         if (empty($branch)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $branch->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Branch deleted successfully',
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
    //         $branch = BranchInfo::find($id);

    //         if (empty($branch)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Branch not found',
    //             ]);
    //         }

    //         $branch->is_active = !$branch->is_active;
    //         $branch->save();

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

    // public function getBranches(){
    //     try {
    //         $branches = BranchInfo::where('is_active', true)->where('name', 'LIKE', '%' . request('search') . '%')->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $branches,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ], 500);
    //     }
    // }

    // public function campaignAssign(string $id): JsonResponse
    // {
    //     try {
    //         $branch = BranchInfo::find($id);

    //         if (empty($branch)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Branch not found',
    //             ]);
    //         }

    //         $campaign_details_id = (int) request('campaign_details_id');

    //         $branch->campaignDetails()->toggle($campaign_details_id);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Assigned or detached successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }
}
