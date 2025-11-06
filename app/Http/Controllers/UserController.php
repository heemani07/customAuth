<?php

namespace App\Http\Controllers;

use App\Models\Role as ModelsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        $roles = Role::pluck('name', 'id'); // Get all role names
        return view('register', compact('roles'));


    }
    /**
     * Handle new user registration
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|exists:roles,id',
            'status' =>'required',
        ]);


//dd($request->only(['name','email','role','status']));

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status' =>$request->status,
        ]);

        // Assign selected role to user
        $role = Role::find($request->role);
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with('success', 'User registered successfully!');
    }

    /**
     * Display user list
     */
    public function index()
    {
        $users = User::with('roles')->get(); // include assigned roles
        $roles=ModelsRole::all();
        return view('user', compact('users','roles'));
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Update user details
     */
public function edit(User $user)
{
    $roles = \Spatie\Permission\Models\Role::pluck('name', 'id');
    $userRole = $user->roles->first(); // get user’s current role

    return view('edit', compact('user', 'roles', 'userRole'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'role' => 'required|exists:roles,id',
        'status'=>'required'
    ]);

    // update basic info
    $data = $request->only(['name', 'email','status']);
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    //Update role using Spatie
    $role = \Spatie\Permission\Models\Role::find($request->role);
    if ($role) {
        $user->syncRoles([$role->name]);
    }

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

public function updateRole(Request $request)
{
    $user = User::find($request->user_id);
    $role = Role::find($request->role_id);

    if ($user && $role) {
        $user->syncRoles([$role->name]); // Spatie method
        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }

   // return response()->json(['success' => false, 'message' => 'User or Role not found']);
   return back()->with('error', 'Something went wrong, please try again.');

}


}
