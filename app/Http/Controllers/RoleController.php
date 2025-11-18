<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function storeRole(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => strtolower($request->validated()['name'])]);

        return response()->json([
            'success' => true,
            'message' => 'Role added successfully!',
            'role' => $role
        ]);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => strtolower($request->validated()['name'])]);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (auth()->user()->roles->contains('id', $id)) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own role.'
            ], 403);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully!'
        ]);
    }
}
