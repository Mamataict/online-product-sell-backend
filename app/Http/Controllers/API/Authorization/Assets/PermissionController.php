<?php

namespace App\Http\Controllers\API\Authorization\Assets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\Assets\StorePermissionRequest;
use App\Http\Requests\Authorization\Assets\UpdatePermissionRequest;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_permission:permission.index')->only(['index']);
        $this->middleware('check_permission:permission.store')->only(['store']);
        $this->middleware('check_permission:permission.show')->only(['show']);
        $this->middleware('check_permission:permission.update')->only(['update']);
        $this->middleware('check_permission:permission.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            if (request('role')) {
                hasPermission('permission.assign');
            }

            $permissions = Permission::with(['roles' => function ($query) {
                if (request('role')) {
                    $query->where('id', request('role'));
                }
            }])
                ->when(request('search'), function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })
                ->orderByDesc('created_at')
                ->paginate(5);

            return response()->json([
                'status' => true,
                'message' => 'Permissions retrieved successfully.',
                'data' => $permissions,
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
    public function store(StorePermissionRequest $request)
    {
        try {
            $permission_create = Permission::create([
                'name' => $request->name,
                'description' => $request->description,
                'guard_name' => $request->guard_name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Permission created successfully.',
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
            $role = Permission::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Permission retrieved successfully.',
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
    public function update(UpdatePermissionRequest $request, string $id)
    {
        try {
            $role = Permission::findOrFail($id);

            $role->name = $request->name;
            $role->description = $request->description;
            $role->guard_name = $request->guard_name;

            $role->save();

            return response()->json([
                'status' => true,
                'message' => 'Permission updated successfully.',
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
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json([
                'status' => true,
                'message' => 'Permission deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
}
