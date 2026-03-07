<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user/update', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/token-test', function () {
    $user = \App\Models\User::first();

    if (!$user) {
        return response()->json(['message' => 'No user found in database. Please seed your database or create a user first.'], 404);
    }
    return $user->createToken('test')->plainTextToken;
});

Route::post('/login', [AuthController::class, 'login']);