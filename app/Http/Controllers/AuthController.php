<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\DTO\RegisterDTO;
use App\DTO\AuthDTO;
use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Метод для регистрации пользователя
    public function register(RegisterRequest $request)
    {
        // Преобразуем запрос в DTO
        $dto = $request->toDTO();

        // Создаем пользователя
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);

        // Возвращаем успешный ответ с созданным пользователем
        return response()->json(['user' => new UserDTO($user)], 201);
    }

    // Метод для авторизации пользователя
    public function login(LoginRequest $request)
    {
        // Преобразуем запрос в DTO
        $dto = $request->toDTO();

        // Проверяем правильность учетных данных
        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Создаем токен доступа
        $token = $request->user()->createToken('auth_token');
        return response()->json(['token' => $token->plainTextToken], 200);
    }

    // Метод для разлогирования пользователя
    public function logout(Request $request)
    {
        // Удаляем все токены текущего пользователя
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }

    // Метод для получения информации о пользователе
    public function getUser(Request $request)
    {
        // Возвращаем информацию о текущем пользователе
        return response()->json(['user' => new UserDTO($request->user())], 200);
    }

    // Метод для обновления пароля
    public function updatePassword(Request $request)
    {
        // Валидация данных для изменения пароля
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        // Проверяем текущий пароль
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json(['message' => 'Invalid current password'], 400);
        }

        // Обновляем пароль
        $request->user()->update(['password' => bcrypt($request->new_password)]);
        return response()->json(['message' => 'Password updated'], 200);
    }

    // Метод для получения всех токенов пользователя
    public function getTokens(Request $request)
    {
        return response()->json($request->user()->tokens, 200);
    }

    // Метод для отзыва всех токенов
    public function revokeAllTokens(Request $request)
    {
        // Удаляем все токены текущего пользователя
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'All tokens revoked'], 200);
    }
}
