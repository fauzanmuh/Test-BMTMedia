<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function show($id)
    {

        $user = User::with('roles')->find($id);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|string|min:6',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->roles()->detach();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function assignRole(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::find($request->role_id);

        if ($user && $role) {
            $user->roles()->attach($role->id);
            return response()->json(['message' => 'Role assigned successfully']);
        }

        return response()->json(['message' => 'User or role not found'], 404);
    }

    public function removeRole(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::find($request->role_id);

        if ($user && $role) {
            $user->roles()->detach($role->id);
            return response()->json(['message' => 'Role removed successfully']);
        }

        return response()->json(['message' => 'User or role not found'], 404);
    }
}