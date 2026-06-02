<?php

namespace App\Http\Controllers\API\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamTypeRequest;
use App\Http\Requests\Team\TeamTypeUpdateRequest;
use App\Http\Resources\Team\TeamTypeResource;
use App\Models\Team\TeamType;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamTypeController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(): JsonResponse
    // {
    //     try {
    //         $team_types = new TeamTypeResource(TeamType::paginate(10));

    //         if ($team_types->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'No team types found',
    //             ]);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'data' => $team_types,
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
        
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(TeamTypeRequest $request): JsonResponse
    // {
    //     try {
    //         $store_team_type = TeamType::create([
    //             'name' => $request->name,
    //         ]);

    //         $store_team_type->view_order = $store_team_type->id;

    //         $store_team_type->save();

    //         if (!empty($store_team_type)) {
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Team type created successfully',
    //             ]);
    //         }

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Team type creation failed',
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show($id): JsonResponse
    // {
    //      try {
    //         $team_type = TeamType::find($id);

    //         return response()->json([
    //             'status' => true,
    //             'data' => $team_type,
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
       
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(TeamTypeUpdateRequest $request, string $id): JsonResponse
    // {
    //     try {
    //         $team_type = TeamType::find($id);

    //         if (!$team_type) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team type not found',
    //             ]);
    //         }

    //         $team_type->update([
    //             'name' => $request->name,
    //             'view_order' => $request->view_order,
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team type updated successfully',
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }

    // public function activation(string $id): JsonResponse
    // {
    //     try {
    //         $team_type = TeamType::find($id);

    //         if (!$team_type) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team type not found',
    //             ]);
    //         }

    //         $team_type->is_active = !$team_type->is_active;
    //         $team_type->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team type activation status updated successfully',
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id): JsonResponse
    // {
    //     try {
    //         $team_type = TeamType::find($id);

    //         if (!$team_type) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team type not found',
    //             ]);
    //         }

    //         $team_type->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team type deleted successfully',
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }
}
