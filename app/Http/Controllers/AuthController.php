<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('backend.auth.login');   // your login blade path
    }

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

            // Role-based redirection
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('clerk')) {
                return redirect()->route('clerk.dashboard');
            }


            // No matching role → logout + send back to login page
            Auth::logout();
            return redirect()->route('login.page')->with('error', 'Unauthorized role');
        }

        return back()->with('error', 'Invalid Email or Password');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page')->with('success', 'Logged out');
    }
}
