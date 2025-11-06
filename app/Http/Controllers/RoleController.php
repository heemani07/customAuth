<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;



class RoleController extends Controller
{
  public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',

        ]);

        // Create and save the new post
        Role::create([
            'name' => $request->name,

        ]);

        // Redirect or return success
        return redirect()->route('permissions.index')->with('success', 'Role created successfully!');
    }
    public function storeRole(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|unique:roles,name|max:255',
    ]);

    $role = Role::create(['name' => strtolower($validated['name'])]);

    return response()->json([
        'success' => true,
        'message' => 'Role added successfully!',
        'role' => $role
    ]);
}
public function destroy(Role $role)
{
    $role->delete();

    return response()->json([
        'success' => true,
        'message' => 'Role deleted successfully!'
    ]);
}

}
