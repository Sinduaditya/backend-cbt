<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        //membuat user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user'
        ]);

        //membuat token
        $token = $user->createToken('auth_token')->plainTextToken;
        //return
        return response()->json([
            'access_token' => $token,
            'user' => UserResource::make($user),
        ]);
   }

   public function login(Request $request){
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // mengambil data user bila email sama dengan login data email dan ambil yang pertama
        $user = User::where('email', $loginData['email'])->first();

        // check apakah usernya tidak ada atau kosong ( null )
        if(!$user){
            return response()->json([
                'message' => 'User Not Found'
            ], 401); // check secara email
        }

        // pengecekan secara hash password sama atau tidak
        if(!Hash::check($loginData['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // setelah semua pengecekan dan bila semua input benar baru createToken dan ambil yang planTextToken
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => UserResource::make($user)
        ]);
   }

   public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logout Success'
    ]);
   }
}
