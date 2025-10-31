<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{

public function index()
{
    $roles = \Spatie\Permission\Models\Role::all();
    $permissions = \Spatie\Permission\Models\Permission::all();


    $modules = $permissions->groupBy(function ($permission) {

        return explode(' ', $permission->name)[1] ?? 'unknown';
    })->map(function ($perms
    ) {

        return $perms->map(function ($perm) {
            return explode(' ', $perm->name)[0] ?? null;
        })->filter()->values();
    });

    return view('permissions.index', compact('roles', 'permissions', 'modules'));
}

public function update(Request $request)
{

    $rolesPermissions = $request->input('permissions', []);


    $roles = \Spatie\Permission\Models\Role::all();

    foreach ($roles as $role) {
        $roleId = $role->id;


        $permissionNames = $rolesPermissions[$roleId] ?? [];

        if (!is_array($permissionNames)) {
            $permissionNames = [];
        }
     $role->syncPermissions($permissionNames);
    }

    return back()->with('success', 'All permissions updated successfully!');
}



}
