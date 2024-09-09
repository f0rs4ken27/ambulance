<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phone_number' => 'required|string',
        'ktp_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file image
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Proses upload gambar
    if ($request->hasFile('ktp_image')) {
        $image = $request->file('ktp_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/ktp_images'), $imageName); // Simpan di folder 'uploads/ktp_images'
        $ktpImagePath = 'uploads/ktp_images/' . $imageName; // Simpan path di database
    }

    // Membuat user baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone_number' => $request->phone_number,
        'ktp_image' => isset($ktpImagePath) ? $ktpImagePath : null, // Simpan path image KTP
    ]);

    // Membuat token untuk user
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ], 201);
}


    // Login
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Mengecek kredensial
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Membuat token untuk user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
    // Logout
public function logout(Request $request)
{
    // Menghapus token yang digunakan untuk autentikasi saat ini
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ], 200);
}

}
