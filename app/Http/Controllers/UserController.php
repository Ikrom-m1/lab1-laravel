<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Метод для сохранения пользователя
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',   // username не обязателен
            'email' => 'required|email|unique:users,email',
            'birthday' => 'nullable|date',         // birthday не обязателен
        ]);

        // Создание пользователя
        $user = User::create([
            'name' => $validated['name'] ?? null,  // Используем null, если не передано значение
            'email' => $validated['email'],
            'birthday' => $validated['birthday'] ?? null, // То же самое для дня рождения
        ]);

        return response()->json($user);
    }
}
