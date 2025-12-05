<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ------------------ LOGIN PAGE ------------------
    public function loginPage()
    {
        return view('backend.auth.login');   // login blade
    }

    // ------------------ LOGIN SUBMIT ------------------
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            $user = Auth::user();

            // Role-based redirects
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('clerk')) {
                return redirect()->route('clerk.dashboard');
            }
            if ($user->hasRole('client')) {
                return redirect()->route('client.dashboard');
            }


            // Unauthorized role
            Auth::logout();
            return redirect()->route('login.page')->with('error', 'Unauthorized role.');
        }

        return back()->with('error', 'Invalid Email or Password.');
    }

    // ------------------ REGISTER PAGE ------------------
    public function registerPage()
    {
        return view('backend.auth.register'); // register blade
    }

    // ------------------ REGISTER SUBMIT ------------------
 public function register(Request $request)
{
    $request->validate([
        "name"         => "required|string|max:100",
        "email"        => "required|email|unique:users,email",
        "password"     => "required|min:6|confirmed",
        "human_check"  => "required|numeric"
    ]);

    // Human check
    if ($request->human_check != session('sum_check')) {
        return back()->withErrors(['human_check' => 'Wrong human verification answer']);
    }

    // Create user
    $user = User::create([
        "name"     => $request->name,
        "email"    => $request->email,
        "password" => Hash::make($request->password)
    ]);

    // 🌟 Assign default role = CLIENT
    $user->assignRole('client');

    return redirect()->route('login.page')
        ->with('success', 'Account created successfully. Please login.');
}


    // ------------------ LOGOUT ------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page')->with('success', 'Logged out successfully');
    }
}
