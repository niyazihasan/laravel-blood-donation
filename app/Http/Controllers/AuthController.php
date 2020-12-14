<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $rules = [
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:6', 'max:8', 'confirmed'],
        'password_confirmation' => ['required_with:password', 'string', 'min:6', 'max:8']
    ];

    private $messages = [
        'email' => 'Невалиден email.',
        'email.required' => 'Въведете еmail.',
        'password.required' => 'Въведете парола.',
        'password.min' => 'Паролата трябва да съдържа минимум 6 символа.',
        'password.max' => 'Паролата не може съдържа повече от 8 символа.',
        'password.confirmed' => 'Паролите са различни.',
        'email.unique' => 'Грешен email.'
    ];

    protected function register()
    {
        $validator = Validator::make(request()->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return response()->json(['fail' => true, 'errors' => $validator->errors()]);
        }
        $user = new User();
        $user->email = request('email');
        $user->password = request('password');
        $user->role = User::ROLE_USER;
        $user->active = User::ACTIVE;
        $user->save();
        auth()->login($user);
        return response()->json(['fail' => false, 'route' => route('profile')]);
    }

    protected function login()
    {
        if (!request('password') && !request('email')) {
            return response()->json(['error' => '', 'fail' => true]);
        }
        if (!auth()->attempt(['email' => request('email'), 'password' => request('password')])) {
            return response()->json(['error' => 'Грешен email/парола.', 'fail' => true]);
        }
        if (!auth()->attempt(['email' => request('email'), 'password' => request('password'), 'active' => User::ACTIVE])) {
            return response()->json(['error' => 'Достъпът Ви е спрян временно.', 'fail' => true]);
        }
        return response()->json(['fail' => false, 'route' => route('profile')]);
    }

    protected function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

}
