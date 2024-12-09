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
            'name' => 'required|string|min:7|regex:/^[A-Z][a-zA-Z]+$/|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[A-Za-z]/',
            'c_password' => 'required|same:password',
            'birthday' => 'required|date|before:2009-12-31',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Имя пользователя должно содержать только буквы латинского алфавита и начинаться с большой буквы.',
            'email.unique' => 'Этот email уже занят.',
            'password.regex' => 'Пароль должен содержать хотя бы одну цифру и одну букву верхнего и нижнего регистра.',
            'c_password.same' => 'Подтверждение пароля не совпадает.',
            'birthday.before' => 'Возраст пользователя должен быть не менее 14 лет.',
        ];
    }
    public function register(Request $request)
{
    $data = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        // другие поля
    ]);

    // Указываем значение для username
    $data['name'] = 'default_name';  // или генерируем его, если это необходимо

    // Создание пользователя
    User::create($data);
}

    public function toResource($user)
{
    return new RegisterResource($user);
}

}
