<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Определяем, может ли пользователь выполнить этот запрос.
     */
    public function authorize(): bool
    {
        return true; // Разрешаем всем пользователям делать запрос на авторизацию
    }

    /**
     * Получаем правила валидации, которые применяются к запросу.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',  // Электронная почта обязательна и должна быть в формате email
            'password' => 'required|string|min:6',  // Пароль обязателен, должен быть строкой и минимум 6 символов
        ];
    }
    public function toDTO()
{
    return new AuthDTO($this->email, $this->password);
}

}

