<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Авторизация разрешена
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:7|regex:/^[A-Z][a-zA-Z]+$/',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[A-Za-z]/',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Имя пользователя должно содержать только буквы латинского алфавита и начинаться с большой буквы.',
            'password.regex' => 'Пароль должен содержать хотя бы одну цифру и одну букву верхнего и нижнего регистра.',
        ];
    }
    public function toResource($user, $token)
{
    return new AuthResource((object) [
        'user' => $user,
        'token' => $token,
    ]);
}

}
