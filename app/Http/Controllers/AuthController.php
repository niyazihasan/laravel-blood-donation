<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var \string[][]
     */
    private $rules = [
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:6', 'max:8', 'confirmed'],
        'password_confirmation' => ['required_with:password', 'string', 'min:6', 'max:8']
    ];

    /**
     * @var string[]
     */
    private $messages = [
        'email' => 'Невалиден email.',
        'email.required' => 'Въведете еmail.',
        'password.required' => 'Въведете парола.',
        'password.min' => 'Паролата трябва да съдържа минимум 6 символа.',
        'password.max' => 'Паролата не може съдържа повече от 8 символа.',
        'password.confirmed' => 'Паролите са различни.',
        'email.unique' => 'Грешен email.'
    ];

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function login()
    {
        if (!auth()->attempt(request(['password', 'email']), true)) {
            return response()->json(['fail' => true, 'error' => 'Грешен email/парола.']);
        }
        if (!auth()->user()->active) {
            auth()->logout();
            return response()->json(['fail' => true, 'error' => 'Вашият акаунт е деактивиран от администратор.']);
        }
        return response()->json(['fail' => false, 'route' => route('profile')]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

}
