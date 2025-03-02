<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/admin/dashboard', function () {
        $user = auth()->user();
        return response()->json([
            'message' => 'Welcome Admin',
            'user_roles' => $user->getRoleNames()
        ]);
    })->middleware('role:Admin');
});
