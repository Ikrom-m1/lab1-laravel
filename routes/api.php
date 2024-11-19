<?php

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
Route::get('/tokens', [AuthController::class, 'getTokens'])->middleware('auth:sanctum');
Route::post('/revoke-all-tokens', [AuthController::class, 'revokeAllTokens'])->middleware('auth:sanctum');
