<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\RegisterDTO;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Разрешаем выполнение запроса для всех пользователей
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',       // Имя должно быть строкой и не больше 255 символов
            'email' => 'required|email|unique:users,email', // Электронная почта должна быть уникальной
            'password' => 'required|string|min:6',     // Пароль должен быть не менее 6 символов
        ];
    }

    /**
     * Преобразует запрос в DTO.
     *
     * @return \App\DTO\RegisterDTO
     */
    public function toDTO(): RegisterDTO
    {
        return new RegisterDTO(
            $this->name,
            $this->email,
            $this->password
        );
    }
}
