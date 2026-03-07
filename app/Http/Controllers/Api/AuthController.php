<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facade\Auth;

class AuthController extends Controller
{
   public function login(Request $request)
   {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'messege' => 'Invalid'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->creatToken('react-app')->plaintextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
   }
}