<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Registrasi pengguna baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|confirmed',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
    }

    // Login pengguna
    public function login(Request $request)
    {
        $request=$request->all();
        Validator::make($request, [
            'name' => 'required|string',
            'password' => 'required|min:3|confirmed',
        ]);
        $user = User::where('email', $request['email'])->first();

        // Cek apakah user ditemukan dan password benar
        if (!$user || !Hash::check($request['password'], $user['password'])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Generate JWT token
        // $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Login successful',
            'token' =>'121fdsfd',
            'user' => $user
        ]);
    }

    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
