<?php

namespace App\Http\Controllers\API\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\StoreCampaignDetailsRequest;
use App\Http\Requests\Campaign\UpdateCampaignDetailsRequest;
use App\Models\Campaign\CampaignDetails;
use App\Models\Campaign\CampaignInfo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignDetailsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('check_permission:campaign.details.index')->only(['index']);
    //     $this->middleware('check_permission:campaign.details.store')->only(['store']);
    //     $this->middleware('check_permission:campaign.details.show')->only(['show']);
    //     $this->middleware('check_permission:campaign.details.update')->only(['update']);
    //     $this->middleware('check_permission:campaign.details.destroy')->only('destroy');
    //     $this->middleware('check_permission:campaign.details.activation')->only('activation');
    // }
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(): JsonResponse
    // {
    //     try {
    //         $campaign_info = CampaignDetails::whereHas('campaign', function ($query) {
    //             $query->where('id', request()->get('campaign_id'));
    //         })
    //         ->with(['campaign', 'branches', 'productPrices'])
    //         ->where('discount_type', 'like', '%' . request('search') . '%')
    //         ->orderByDesc('created_at')
    //         ->paginate(10);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => $campaign_info,
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
    //         $campaigns = CampaignInfo::active()->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => [
    //                 'campaigns' => $campaigns,
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
    // public function store(StoreCampaignDetailsRequest $request): JsonResponse
    // {
    //     try {
    //         $store_campaign_details = CampaignDetails::create([
    //             'price' => 0,
    //             'discount_type' => $request->discount_type,
    //             'discount' => $request->discount,
    //             'campaign_info_id' => $request->campaign_info_id,
    //             'effect_date' => $request->effect_date,
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
    //         $campaign_info = CampaignInfo::orderByDesc('created_at')->get();
    //         $campaign_details = CampaignDetails::find($id);

    //         if (empty($campaign_details)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => [
    //                 'campaign_info' => $campaign_info,
    //                 'campaign_details' => $campaign_details
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
    // public function update(UpdateCampaignDetailsRequest $request, string $id)
    // {
    //     try {
    //         $campaign_details = CampaignDetails::find($id);

    //         if (empty($campaign_details)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $campaign_details->update([
    //             'discount_type' => $request->discount_type,
    //             'discount' => $request->discount,
    //             'campaign_info_id' => $request->campaign_info_id,
    //             'effect_date' => $request->effect_date,
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
    //         $campaign_details = CampaignDetails::find($id);

    //         if (empty($campaign_details)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data not found',
    //             ], 404);
    //         }

    //         $campaign_details->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Campaign info deleted successfully',
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
    //         $campaign_details = CampaignDetails::find($id);

    //         if (empty($campaign_details)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Campaign info not found',
    //             ]);
    //         }

    //         $campaign_details->is_active = !$campaign_details->is_active;
    //         $campaign_details->save();

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
