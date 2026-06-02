<?php

namespace App\Http\Controllers\API\Authorization\Assets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\Assets\StoreRoleRequest;
use App\Http\Requests\Authorization\Assets\UpdateRoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_permission:role.index')->only(['index']);
        $this->middleware('check_permission:role.store')->only(['store']);
        $this->middleware('check_permission:role.show')->only(['show']);
        $this->middleware('check_permission:role.update')->only(['update']);
        $this->middleware('check_permission:role.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            if (request('user')) {
                hasPermission('role.assign');
            }

            $roles = Role::with(['users' => function ($query) {
                if (request('user')) {
                    $query->where('id', request('user'));
                }
            }])

                ->when(request('search'), function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })
                ->orderByDesc('created_at')
                ->paginate(5);

            return response()->json([
                'status' => true,
                'message' => 'Roles retrieved successfully.',
                'data' => $roles,
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
    public function store(StoreRoleRequest $request)
    {
        try {
            $role_create = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Role created successfully.',
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $role = Role::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Role retrieved successfully.',
                'data' => $role,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        try {
            $role = Role::findOrFail($id);

            $role->name = $request->name;
            $role->guard_name = $request->guard_name;

            $role->save();

            return response()->json([
                'status' => true,
                'message' => 'Role updated successfully.',
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
            $role = Role::findOrFail($id);
            $role->forceDelete();

            return response()->json([
                'status' => true,
                'message' => 'Role deleted successfully.',
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
