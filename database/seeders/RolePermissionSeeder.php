<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [
            ['name' => 'role.index', 'description' => '<p>Role List</p>', 'guard_name' => 'api'],
            ['name' => 'role.store', 'description' => '<p>To Store Role</p>', 'guard_name' => 'api'],
            ['name' => 'permission.index', 'description' => '<p>Permission List</p>', 'guard_name' => 'api'],
            ['name' => 'permission.store', 'description' => '<p>To Store Permission</p>', 'guard_name' => 'api'],
            ['name' => 'user.index', 'description' => '<p>User List</p>', 'guard_name' => 'api'],
            ['name' => 'user.store', 'description' => '<p>Register User</p>', 'guard_name' => 'api'],
            ['name' => 'user.destroy', 'description' => '<p>To delete user</p>', 'guard_name' => 'api'],
            ['name' => 'permission.assign', 'description' => '<p>Assign permission</p>', 'guard_name' => 'api'],
            ['name' => 'role.assign', 'description' => '<p>To Assign Role</p>', 'guard_name' => 'api'],
            ['name' => 'user.show', 'description' => '<p>To show user Details</p>', 'guard_name' => 'api'],
            
            ['name' => 'role.show', 'description' => '<p>To show role</p>', 'guard_name' => 'api'],
            ['name' => 'role.update', 'description' => '<p>To show update</p>', 'guard_name' => 'api'],
            ['name' => 'role.destroy', 'description' => '<p>To update role</p>', 'guard_name' => 'api'],
            ['name' => 'permission.show', 'description' => '<p>To show permission</p>', 'guard_name' => 'api'],
            ['name' => 'permission.update', 'description' => '<p>To update permission</p>', 'guard_name' => 'api'],
            ['name' => 'permission.destroy', 'description' => '<p>To delete permission</p>', 'guard_name' => 'api'],
            ['name' => 'product_category.index', 'description' => '<p>To show all product category</p>', 'guard_name' => 'api'],
            ['name' => 'product_category.store', 'description' => '<p>To store product category</p>', 'guard_name' => 'api'],
            ['name' => 'product_category.destroy', 'description' => '<p>To delete product category</p>', 'guard_name' => 'api'],
            ['name' => 'product_category.show', 'description' => '<p>To show product category</p>', 'guard_name' => 'api'],
            ['name' => 'product_category.update', 'description' => '<p>To update product category</p>', 'guard_name' => 'api'],
            ['name' => 'product_category.activation', 'description' => '<p>To activate product category</p>', 'guard_name' => 'api'],
            ['name' => 'product.index', 'description' => '<p>To show all product</p>', 'guard_name' => 'api'],
            ['name' => 'product.store', 'description' => '<p>To store product</p>', 'guard_name' => 'api'],
            ['name' => 'product.destroy', 'description' => '<p>To delete product</p>', 'guard_name' => 'api'],
            ['name' => 'product.show', 'description' => '<p>To show product</p>', 'guard_name' => 'api'],
            ['name' => 'product.update', 'description' => '<p>To update product</p>', 'guard_name' => 'api'],
            ['name' => 'product.activation', 'description' => '<p>To activate product</p>', 'guard_name' => 'api'],
            // ['name' => 'supplier.index', 'description' => '<p>To show all supplier</p>', 'guard_name' => 'api'],
            // ['name' => 'supplier.store', 'description' => '<p>To store supplier</p>', 'guard_name' => 'api'],
            // ['name' => 'supplier.show', 'description' => '<p>To show supplier</p>', 'guard_name' => 'api'],
            // ['name' => 'supplier.update', 'description' => '<p>To update supplier</p>', 'guard_name' => 'api'],
            // ['name' => 'supplier.destroy', 'description' => '<p>To delete supplier</p>', 'guard_name' => 'api'],
            // ['name' => 'supplier.activation', 'description' => '<p>To activate supplier</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.index', 'description' => '<p>To show all branch</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.store', 'description' => '<p>To store branch</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.show', 'description' => '<p>To show branch</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.update', 'description' => '<p>To update branch</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.destroy', 'description' => '<p>To delete branch</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.activation', 'description' => '<p>To activate branch</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.index', 'description' => '<p>To show all campaign</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.store', 'description' => '<p>To store campaign</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.show', 'description' => '<p>To show campaign</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.update', 'description' => '<p>To update campaign</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.destroy', 'description' => '<p>To delete campaign</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.activation', 'description' => '<p>To activate campaign</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.details.index', 'description' => '<p>To show all campaign details</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.details.store', 'description' => '<p>To store campaign details</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.details.show', 'description' => '<p>To show campaign details</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.details.update', 'description' => '<p>To update campaign details</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.details.destroy', 'description' => '<p>To delete campaign details</p>', 'guard_name' => 'api'],
            // ['name' => 'campaign.details.activation', 'description' => '<p>To activate campaign details</p>', 'guard_name' => 'api'],
            // ['name' => 'branch.campaign.assign', 'description' => '<p>To assign campaign to the branches</p>', 'guard_name' => 'api'],
            // ['name' => 'user.branch.assign', 'description' => '<p>To assign user to branches</p>', 'guard_name' => 'api'],
            ['name' => 'order.index', 'description' => '<p>To see orders</p>', 'guard_name' => 'api'],
            ['name' => 'order.store', 'description' => '<p>To store order</p>', 'guard_name' => 'api'],
            // ['name' => 'branches.orders', 'description' => '<p>To see branches orders</p>', 'guard_name' => 'api'],
            ['name' => 'dasboard.info', 'description' => '<p>To see dashboard info</p>', 'guard_name' => 'api'],
            ['name' => 'order.inquiry', 'description' => '<p>To inquiry orders</p>', 'guard_name' => 'api'],
            ['name' => 'order.cancel', 'description' => '<p>To cancel orders</p>', 'guard_name' => 'api'],  
            ['name' => 'order.print', 'description' => '<p>To print order</p>', 'guard_name' => 'api'],  
        ];

        $role = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'api']
        );

        $permissionModels = [];
        foreach ($permissions as $permData) {
            $permission = Permission::firstOrCreate(
                ['name' => $permData['name'], 'guard_name' => $permData['guard_name']],
                ['description' => $permData['description']]
            );
            $permissionModels[] = $permission;
        }

        $existingPermissionIds = $role->permissions()->pluck('id')->toArray();
        $newPermissionIds = collect($permissionModels)->pluck('id')->filter(function ($id) use ($existingPermissionIds) {
            return !in_array($id, $existingPermissionIds);
        });
        if ($newPermissionIds->isNotEmpty()) {
            $role->permissions()->attach($newPermissionIds);
        }

        $user = User::where('username', '021868')->first();
        if ($user) {
            $existingRoleIds = $user->roles()->pluck('id')->toArray();
            if (!in_array($role->id, $existingRoleIds)) {
                $user->roles()->attach($role->id);
            }
        }

    }
}
