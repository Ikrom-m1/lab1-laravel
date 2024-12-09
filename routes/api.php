<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Регистрация
Route::post('auth/register', [AuthController::class, 'register']);
// Авторизация
Route::post('auth/login', [AuthController::class, 'login']);
Route::prefix('auth:sanctum')->group(function() {
Route::get('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('tokens', [AuthController::class, 'tokens'])->middleware('auth:api');
Route::post('out_all', [AuthController::class, 'logoutAll'])->middleware('auth:api');
});