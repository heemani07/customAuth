<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
    $users = User::all();
    return view('user', compact('users'));
    }

    public function destroy(User $user)
    {
    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

public function edit(User $user)
{
    return view('edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password'=>'nullable|min:6',
    ]);

    $data = $request->only(['name', 'email']);
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);
    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}
}
