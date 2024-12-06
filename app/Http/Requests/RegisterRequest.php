<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:7|regex:/^[A-Z][a-zA-Z]+$/|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[A-Za-z]/',
            'c_password' => 'required|same:password',
            'birthday' => 'required|date|before:2009-12-31',
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => 'Имя пользователя должно содержать только буквы латинского алфавита и начинаться с большой буквы.',
            'email.unique' => 'Этот email уже занят.',
            'password.regex' => 'Пароль должен содержать хотя бы одну цифру и одну букву верхнего и нижнего регистра.',
            'c_password.same' => 'Подтверждение пароля не совпадает.',
            'birthday.before' => 'Возраст пользователя должен быть не менее 14 лет.',
        ];
    }
}
