<?php

namespace App\Http\Controllers\API\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\StoreCampaignInfoRequest;
use App\Http\Requests\Campaign\UpdateCampaignInfoRequest;
use App\Models\Branch\BranchInfo;
use App\Models\Campaign\CampaignInfo;
use App\Models\Product\ProductPrices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignInfoController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('check_permission:campaign.index')->only(['index']);
    //     $this->middleware('check_permission:campaign.store')->only(['store']);
    //     $this->middleware('check_permission:campaign.show')->only(['show']);
    //     $this->middleware('check_permission:campaign.update')->only(['update']);
    //     $this->middleware('check_permission:campaign.destroy')->only('destroy');
    //     $this->middleware('check_permission:campaign.activation')->only('activation');
    // }
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(): JsonResponse
    // {
    //     try {
    //         $campaigns = CampaignInfo::with('details')->when(request('search'), function ($query) {
    //             $query->where('name', 'like', '%' . request('search') . '%');
    //         })
    //         ->orderByDesc('created_at')
    //         ->paginate(10);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $campaigns,
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

    //         $search_by = '';

    //         if(request()->has('product')){
    //             $search_by = 'product';
    //         }else if (request()->has('branch')){
    //             $search_by = 'branch';
    //         }

    //         $product_prices = ProductPrices::whereHas('product', function ($query) use ($search_by) {
    //             $query->when($search_by == 'product', function ($q) {
    //                 $q->where('name', 'like', '%' . request()->get('product') . '%')->active();
    //             });
    //         })->with('product')->active()->paginate(10);

    //         $branches = BranchInfo::when($search_by == 'branch', function ($q) {
    //             $q->where('name', 'like', '%' . request()->get('branch') . '%');
    //         })->active()->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => [
    //                 'product_prices' => $product_prices,
    //                 'branches' => $branches,
    //                 'search_by' => $search_by
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
    // public function store(StoreCampaignInfoRequest $request): JsonResponse
    // {
    //     try {
    //         $store_campaign_info = CampaignInfo::create([
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

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id): JsonResponse
    // {
    //     try {
    //         $campaign = CampaignInfo::find($id);

    //         if (empty($campaign)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $campaign,
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
    // public function update(UpdateCampaignInfoRequest $request, string $id)
    // {
    //     try {
    //         $campaign = CampaignInfo::find($id);

    //         if (empty($campaign)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $campaign->update([
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

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id): JsonResponse
    // {
    //     try {
    //         $campaign = CampaignInfo::find($id);

    //         if (empty($campaign)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $campaign->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Campaign deleted successfully',
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
    //         $campaign = CampaignInfo::find($id);

    //         if (empty($campaign)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Campaign not found',
    //             ]);
    //         }

    //         $campaign->is_active = !$campaign->is_active;
    //         $campaign->save();

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
