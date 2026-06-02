<?php

namespace App\Http\Controllers\API\UserDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Branch\BranchInfo;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:user.index')->only(['index']);
        $this->middleware('check_permission:user.branch.assign')->only(['assignBranch']);
        $this->middleware('check_permission:user.destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = new UserResource(User::orderByDesc('created_at')->paginate(10));

            return response()->json([
                'status' => true,
                'message' => 'Users retrieved successfully.',
                'data' => $users,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {

            $user_details = User::find($id);
            $user_details->name = $request->name;
            $user_details->email = $request->username;
            $user_details->username = $request->username;

            if ($request->password) {
                $user_details->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                if ($user_details->image && Storage::disk('public')->exists('images/profile_pictures/' . $user_details->image)) {
                    Storage::disk('public')->delete('images/profile_pictures/' . $user_details->image);
                }
                $image = $request->file('image');
                $imageName = (new DateTime())->format('YmdHisu') . '.' . $image->extension();
                $image->storeAs('images/profile_pictures', $imageName, 'public');
                $user_details->image = $imageName;
            }

            $user_details->save();

            return response()->json([
                'status' => true,
                'message' => 'Registration successful.',
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->image && Storage::disk('public')->exists('images/profile_pictures/' . $user->image)) {
                Storage::disk('public')->delete('images/profile_pictures/' . $user->image);
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function assignBranch(string $id)
    {
        try {
            $branch = BranchInfo::findOrFail($id);

            $user = User::find(request('user_id'));

            if ($user) {
                $user->branches()->sync([$branch->id]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Info Updated successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
}
