<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show all users (only admin)
    public function index()
    {
        $users = User::with('groups')->get();
        return view('admin.index', compact('users'));
    }

    // Show create form
    public function create()
    {
        $groups = Group::all();
        return view('admin.create', compact('groups'));
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'group_id'  => 'required|exists:groups,id',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        // Assign group (role)
        $user->groups()->sync([$request->group_id]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    // Edit form
    public function edit(User $user)
    {
        $groups = Group::all();
        return view('admin.edit', compact('user', 'groups'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'group_id'  => 'required|exists:groups,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->groups()->sync([$request->group_id]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
