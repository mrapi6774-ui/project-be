<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OpdController;
use App\Http\Controllers\Api\InnovationController;

// Public Routes (Bisa diakses tanpa token)
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/opds', [OpdController::class, 'index']);
Route::get('/opds/{id}', [OpdController::class, 'show']);
Route::get('/innovations', [InnovationController::class, 'index']);
Route::get('/innovations/{id}', [InnovationController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Wajib menyertakan Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //CRUD OPD oleh Admin / Operator Pusat
    Route::post('/opds', [OpdController::class, 'store']);
    Route::put('/opds/{id}', [OpdController::class, 'update']);
    Route::delete('/opds/{id}', [OpdController::class, 'destroy']);

    // CRUD Inovasi
    Route::post('/innovations', [InnovationController::class, 'store']);
    Route::put('/innovations/{id}', [InnovationController::class, 'update']);
    Route::delete('/innovations/{id}', [InnovationController::class, 'destroy']);
});