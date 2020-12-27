<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserForm
 * @package App\Http\Requests
 */
class UserForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route('user')->id ?? 0;
        return [
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'password' => $userId && $this->request->get('password') === null ? '' : 'required|min:6|max:8',
            'role' => 'required|in:ROLE_USER,ROLE_ADMIN,ROLE_DOCTOR,ROLE_LABORANT,ROLE_SUPERDOCTOR',
            'active' => 'required',
            'hospital_id' => $this->request->get('role') === \App\Models\User::ROLE_DOCTOR ? 'required' : ''
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'password.required' => 'Въведете парола.',
            'password.min' => 'Паролата трябва да съдържа минимум 6 символа.',
            'password.max' => 'Паролата не може съдържа повече от 8 символа.',
            'role.required' => 'Изберете тип.',
            'role.in' => 'Невалиден тип.',
            'email.required' => 'Въведете еmail.',
            'email' => 'Невалиден email.',
            'email.unique' => 'Грешен email.',
            'hospital_id.required' => 'Изберете болница.',
            'active.required' => 'Маркирайте активност.'
        ];
    }
}
