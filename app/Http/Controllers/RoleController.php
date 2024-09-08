<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::all(), 200);
    }

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    public function show($id)
    {
        return response()->json(Role::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}