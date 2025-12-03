<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => ['required'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'newPassword.confirmed' => 'The new password confirmation does not match.'
        ]);

        $user = Auth::user();

        if (! Hash::check($request->input('oldPassword'), $user->password)) {
            return back()->withErrors(['oldPassword' => 'Old password is incorrect.'])->withInput();
        }

        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

        return redirect()->back()->with('password_success', 'Password changed successfully.');

    }
}
