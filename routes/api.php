<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/token-test', function () {
    $user = \App\Models\User::first();
    
    if (!$user) {
        return response()->json(['message' => 'No user found in database. Please seed your database or create a user first.'], 404);
    }
    return $user->createToken('test')->plainTextToken;
});

Route::post('/login', [AuthController::class, 'login']);