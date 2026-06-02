<?php

namespace App\Http\Controllers\API\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamMemberStoreRequest;
use App\Models\Team\TeamMember;
use App\Models\Team\TeamType;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create(): JsonResponse
    // {
    //     try {
    //         $team_types = TeamType::where('is_active', true)
    //             ->orderBy('view_order', 'asc')
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data for creating a new team member',
    //             'data' => [
    //                 'team_types' => $team_types
    //             ]
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong!',
    //         ]);
    //     }
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(TeamMemberStoreRequest $request): JsonResponse
    // {
    //     try {
    //         $store_team_member = TeamMember::create(
    //             [
    //                 'name' => $request->name,
    //                 'alt_tag' => $request->alt_tag,
    //                 'post' => $request->post,
    //             ]
    //         );

    //         TeamType::find($request->team_type_id)->teams()->attach($store_team_member->id, ['view_order' => $request->view_order]);

    //         if ($request->hasFile('image')) {
    //             $image = $request->file('image');
    //             $imageName = (new DateTime())->format('YmdHisu') . '.' . $image->extension();
    //             $image->storeAs('images/team_members', $imageName, 'public');
    //             $store_team_member->image = $imageName;
    //             $store_team_member->save();
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team member created successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong while creating the team member',
    //         ]);
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id): JsonResponse
    // {
    //     try {

    //         $team_types = TeamType::orderBy('view_order', 'asc')
    //             ->get();

    //         $team_member = TeamMember::with('teamTypes')->find($id);

    //         if (!$team_member) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team member not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team member retrieved successfully',
    //             'data' => [
    //                 'team_member' => $team_member,
    //                 'team_types' => $team_types
    //             ],
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
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id): JsonResponse
    // {
    //     try {
    //         $team_member = TeamMember::find($id);

    //         if (!$team_member) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team member not found',
    //             ]);
    //         }

    //         $team_member->update([
    //             'name' => $request->name,
    //             'alt_tag' => $request->alt_tag,
    //             'post' => $request->post,
    //         ]);

    //         if ($request->filled('team_type_id') && $request->filled('view_order')) {

    //             if (!$team_member->teamTypes->contains($request->team_type_id)) {
    //                 return response()->json([
    //                     'status' => false,
    //                     'message' => 'Team type not associated with this member',
    //                 ]);
    //             }
    //             TeamType::findOrFail($request->team_type_id)->teams()->updateExistingPivot($team_member->id, [
    //                 'view_order' => $request->view_order,
    //             ]);
    //         }

    //         if ($request->hasFile('image')) {

    //             if ($team_member->image && Storage::disk('public')->exists('images/team_members/' . $team_member->image)) {
    //                 Storage::disk('public')->delete('images/team_members/' . $team_member->image);
    //             }
    //             $image = $request->file('image');
    //             $imageName = (new DateTime())->format('YmdHisu') . '.' . $image->extension();
    //             $image->storeAs('images/team_members', $imageName, 'public');
    //             $team_member->image = $imageName;
    //             $team_member->save();
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team member updated successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong while updating the team member',
    //         ]);
    //     }
    // }

    // public function activation(string $id): JsonResponse
    // {
    //     try {
    //         $team_member = TeamMember::find($id);

    //         if (!$team_member) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team member not found',
    //             ]);
    //         }

    //         $team_member->is_active = !$team_member->is_active;
    //         $team_member->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team member activation status updated successfully',
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
    //         $team_member = TeamMember::find($id);

    //         if (!$team_member) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Team member not found',
    //             ]);
    //         }

    //         if ($team_member->image && Storage::disk('public')->exists('images/team_members/' . $team_member->image)) {
    //             Storage::disk('public')->delete('images/team_members/' . $team_member->image);
    //         }

    //         $team_member->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Team member deleted successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong while deleting the team member',
    //         ]);
    //     }
    // }
}
