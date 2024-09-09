<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    public function uploadProfilePicture(Request $request, $id)
{
    // Validasi file gambar
    $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Temukan user berdasarkan ID
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Ambil file gambar
    $image = $request->file('profile_image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();

    // Simpan gambar ke storage
    $imagePath = $image->storeAs('profile_images', $imageName);

    // Simpan path gambar ke database
    $user->profile_image = $imageName;
    $user->save();

    return response()->json(['message' => 'Profile picture uploaded successfully', 'user' => $user], 200);
}

    private function optimizeImage($image, $path)
    {

        $imageType = $image->getClientOriginalExtension();

        switch ($imageType) {
            case 'jpeg':
            case 'jpg':
                $imgResource = imagecreatefromjpeg($image->getPathname());
                break;
            case 'png':
                $imgResource = imagecreatefrompng($image->getPathname());
                break;
            case 'gif':
                $imgResource = imagecreatefromgif($image->getPathname());
                break;
            case 'webp':
                $imgResource = imagecreatefromwebp($image->getPathname());
                break;
            default:
                throw new \Exception('Invalid image type');
        }

        list($width, $height) = getimagesize($image);

        $newWidth = 300;
        $newHeight = 300;
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $imgResource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        switch ($imageType) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($resizedImage, $path, 80);
                break;
            case 'png':
                imagepng($resizedImage, $path, 8);
                break;
            case 'gif':
                imagegif($resizedImage, $path);
                break;
            case 'webp':
                imagewebp($resizedImage, $path, 80);
                break;
        }

        imagedestroy($imgResource);
        imagedestroy($resizedImage);
    }
}