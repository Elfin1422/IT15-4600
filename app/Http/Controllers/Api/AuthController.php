<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request) 
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8'
    ]);

    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    $token = $user->createToken('react-app')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
    }

   public function login(Request $request)
   {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
            'message' => 'Invalid email or password'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('react-app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
   }
   public function updateProfile(Request $request)
    {
    $user = $request->user();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|min:8',
    ]);

    $user->name = $data['name'];

    if (!empty($data['password'])) {
        $user->password = bcrypt($data['password']);
    }

    $user->save();

    return response()->json([
        'message' => 'Account updated successfully',
        'user' => $user
    ]);
    }
}