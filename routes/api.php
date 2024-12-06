<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('auth/me', [AuthController::class, 'me'])->middleware('auth:api');
Route::post('auth/out', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('auth/tokens', [AuthController::class, 'tokens'])->middleware('auth:api');
Route::post('auth/out_all', [AuthController::class, 'logoutAll'])->middleware('auth:api');
