<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class AuthController extends Controller
{
public function login(Request $request)
{

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);


    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();
       return redirect()->intended('/dashboard');
    }


    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ])->onlyInput('email');
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out successfully!');;
    }
    public function showLoginForm(): View
    {

        return view('auth.login');
    }
    public function registration(): View
    {

        return view('auth.registration');
    }

        public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

        public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

}
