<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $default_email = 'test@example.com';
    private $default_password = 'Reymart1234';
    private $default_first_name = 'Reymart';
    private $default_last_name = 'Calicdan';
    private $default_role = 'superadmin';
    private $default_id = 1;

    public function __construct()
    {
        if (!User::where('id', $this->default_id)->exists()) {
            User::create([
                'firstName' => $this->default_first_name,
                'lastName' => $this->default_last_name,
                'email' => $this->default_email,
                'password' => $this->default_password,
                'role' => $this->default_role,
            ]);

            return;
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email address does not match records!'
            ])->onlyInput('email');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Password is incorrect!'
            ])->onlyInput('email');
        }

        Auth::login($user);

        if ($user->role === 'superadmin') {
            $request->session()->regenerate();
            return redirect()->intended('superadmin/dashboard');
        } elseif ($user->role === 'admin') {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        } elseif ($user->role === 'employee') {
            $request->session()->regenerate();
            return redirect()->intended('employee/dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
