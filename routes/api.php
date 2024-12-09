<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Регистрация
Route::post('auth/register', [AuthController::class, 'register']);
// Авторизация
Route::post('auth/login', [AuthController::class, 'login']);
Route::prefix('auth')->group(function() {
     Route::get('user', [AuthController::class, 'me'])->middleware('auth:sanctum');
     Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
     Route::get('tokens', [AuthController::class, 'tokens'])->middleware('auth:sanctum');
     Route::post('out_all', [AuthController::class, 'logoutAll'])->middleware('auth:api');
});