<?php

namespace App\Http\Controllers\API\AssetsCus;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetsCus\AchievementStoreRequest;
use App\Models\AssetsCus\Achievement;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(AchievementStoreRequest $request)
    // {
    //    try {
    //         $store_achievement = Achievement::create(
    //             [
    //                 'title' => $request->title,
    //                 'description' => $request->description,
    //                 'alt_tag' => $request->alt_tag,
    //                 'view_order' => $request->view_order,
    //             ]
    //         );

    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $fileName = (new DateTime())->format('YmdHisu') . '.' . $file->extension();
    //             $file->storeAs('images/achievements', $fileName, 'public');
    //             $store_achievement->file = $fileName;
    //             $store_achievement->save();
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Achievement record created successfully',
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
    // public function show(string $id)
    // {
    //     try {
    //         $achievement = Achievement::find($id);

    //         if (!$achievement) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Achievement not found',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Achievement retrieved successfully',
    //             'data' => $achievement,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     try {
    //         $achievement = Achievement::find($id);

    //         if (!$achievement) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Achievement not found',
    //             ], 404);
    //         }

    //         $achievement->update($request->only(['title', 'description', 'alt_tag', 'view_order']));

    //         if ($request->hasFile('file')) {
    //             if ($achievement->file && Storage::disk('public')->exists('images/achievements/' . $achievement->image)) {
    //                 Storage::disk('public')->delete('images/achievements/' . $achievement->image);
    //             }
    //             $file = $request->file('file');
    //             $fileName = (new DateTime())->format('YmdHisu') . '.' . $file->extension();
    //             $file->storeAs('images/achievements', $fileName, 'public');
    //             $achievement->file = $fileName;
    //             $achievement->save();
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Achievement updated successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong while updating the achievement',
    //         ]);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     try {
    //         $achievement = Achievement::find($id);

    //         if (!$achievement) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Achievement not found',
    //             ], 404);
    //         }

    //         if ($achievement->file && Storage::disk('public')->exists('images/achievements/' . $achievement->file)) {
    //             Storage::disk('public')->delete('images/achievements/' . $achievement->file);
    //         }

    //         $achievement->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Achievement deleted successfully',
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong while deleting the achievement',
    //         ]);
    //     }
    // }

    // public function activation(string $id)
    // {
    //     try {
    //         $achievement = Achievement::find($id);

    //         if (!$achievement) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Achievement not found',
    //             ]);
    //         }

    //         $achievement->is_active = !$achievement->is_active;
    //         $achievement->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Achievement activation status updated successfully',
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong',
    //         ]);
    //     }
    // }
}
