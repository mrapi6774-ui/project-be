<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

// Public Routes (Bisa diakses tanpa token)
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Wajib menyertakan Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});