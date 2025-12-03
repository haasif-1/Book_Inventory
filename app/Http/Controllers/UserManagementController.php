<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('backend.admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name');
        return view('backend.admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
            "role" => "required|in:admin,clerk"
        ]);

        $user = User::create([
            "name"  => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User Created');
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('backend.admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated');
    }

    public function destroy(User $user)
{
    // Prevent admin from deleting his own account
    if (auth()->id() === $user->id) {
        return redirect()->route('users.index')
            ->with('error', 'You cannot delete your own account.');
    }

    // Remove assigned roles (Spatie)
    $user->syncRoles([]);

    // Delete the user
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User deleted successfully');
}

}
