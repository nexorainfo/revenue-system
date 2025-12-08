<?php

namespace App\Traits;

use App\Models\UserManagement\Permission;
use App\Models\UserManagement\Role;

trait StorePermissionTrait
{
    final public function storePermission(array $permissions): void
    {
        Permission::whereIn('title', $permissions)->delete();

        $permissionId = collect();
        foreach ($permissions as $permission) {
            $permission = Permission::create(['title' => $permission]);

            $permissionId->push($permission->id);
        }
        $role = Role::first();
        $role->permissions()->sync($permissionId, []);

    }
}
