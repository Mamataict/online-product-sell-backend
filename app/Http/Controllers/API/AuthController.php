<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\User\UserDataResource;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:user.store')->only(['register']);
        // $this->middleware('check_permission:user.show')->only(['profile']);
    }
    public function login(LoginRequest $request): JsonResponse
    {
        try {

            if (!Auth::attempt($request->only('username', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Credential Missmatched.',
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful.',
                'data' => [
                    'token' => $token,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        try {
            $user_create = User::create([
                'name' => $request->name,
                'email' => $request->username,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = (new DateTime())->format('YmdHisu') . '.' . $image->extension();
                $image->storeAs('images/profile_pictures', $imageName, 'public');
                $user_create->image = $imageName;
                $user_create->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Registration successful.',
                'data' => [
                    'user' => $user_create->id
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {

            $data = new UserDataResource(Auth::guard('api')->user());
            
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function userProfile($id)
    {
        try {

            $data = new UserDataResource(User::find($id));
            
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
    }
}
