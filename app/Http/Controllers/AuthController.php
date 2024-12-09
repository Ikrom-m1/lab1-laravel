<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Регистрация
    public function register(RegisterRequest $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[A-Za-z]/',
        'birthday' => 'required|date|before:today',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'birthday' => $validated['birthday'],
    ]);

    // Создание токена с конкретными правами
    $token = $user->createToken('API Token', [
        'view-profile', 
        'update-profile', 
        'logout', 
        'change-password'
    ])->plainTextToken;

    return response()->json([
        'message' => 'Registration successful',
        'user' => $user,
        'token' => $token
    ], 201);
}


    // Авторизация
    // Авторизация
public function login(LoginRequest $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();

        // Указываем конкретные права доступа
        $abilities = ['view-profile', 'update-profile', 'logout', 'change-password'];

        // Создаем токен с правами
        $token = $user->createToken('API Token', $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'abilities' => $abilities
        ]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
}


    // Получение информации о пользователе
    public function me()
    {
        return response()->json([
            'user' => auth()->user(),
        ]);
    }

    // Разлогирование
    public function logout()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }

    // Получение токенов пользователя

public function tokens()
{
    $tokens = Auth::user()->tokens->map(function ($token) {
        return [
            'id' => $token->id,
            'name' => $token->name,
            'abilities' => $token->abilities, // Показ прав токена
            'token' => $token->token,
            'last_used_at' => $token->last_used_at,
            'expires_at' => $token->expires_at,
            'created_at' => $token->created_at,
            'updated_at' => $token->updated_at,
        ];
    });

    return response()->json($tokens);
}


    // Разлогирование всех токенов
    public function logoutAll()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'All tokens have been revoked']);
    }

    // Смена пароля
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
}
