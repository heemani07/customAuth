<?php

namespace App\Http\Controllers;

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
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
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
        return view('user', compact('users'));
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
     * Show edit form
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        return view('edit', compact('user', 'roles'));
    }

    /**
     * Update user details
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'nullable|min:6',
            'role'     => 'nullable|exists:roles,id',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Update role if provided
        if ($request->filled('role')) {
            $role = Role::find($request->role);
            $user->syncRoles([$role->name]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
