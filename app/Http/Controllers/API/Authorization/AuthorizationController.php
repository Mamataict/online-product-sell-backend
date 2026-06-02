<?php

namespace App\Http\Controllers\API\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:permission.assign')->only(['givePermission']);
        $this->middleware('check_permission:role.assign')->only(['assignRole']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function givePermission(Role $role){
        try {
            $role->permissions()->toggle([request('permission')]);

            return response()->json([
                'status' => true,
                'message' => 'Permission assigned or detached successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
    public function assignRole(User $user){
        try {
            $user->roles()->toggle([request('role')]);

            return response()->json([
                'status' => true,
                'message' => 'Role assigned or detached successfully.',
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
