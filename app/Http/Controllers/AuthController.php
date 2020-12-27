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
        if (!request('password') && !request('email')) {
            return response()->json(['error' => '', 'fail' => true]);
        }
        $user = User::select('active')->where('email', request('email'))->first();
        if ($user && !$user->active) {
            return response()->json(['error' => 'Вашият акаунт е деактивиран от администратор.', 'fail' => true]);
        }
        if (!auth()->attempt(['email' => request('email'), 'password' => request('password')], true)) {
            return response()->json(['error' => 'Грешен email/парола.', 'fail' => true]);
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
