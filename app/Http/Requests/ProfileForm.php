<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileForm extends FormRequest
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
        return [
            'email' => 'required|email|unique:users,email,'.auth()->id().',id',
            'name' => 'required|min:3|max:25',
            'fathersname' => 'required|min:3|max:25',
            'surname' => 'required|min:3|max:25',
            'egn' => 'required|digits_between:10,10',
            'password' => 'nullable|min:6|max:8',
            'city_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Въведете име.',
            'name.min' => 'Името трябва да съдържа минимум 3 символа.',
            'name.max' => 'Името може да съдържа максимум 25 символа.',
            'fathersname.required' => 'Въведете презиме.',
            'fathersname.min' => 'Презиме трябва да съдържа минимум 3 символа.',
            'fathersname.max' => 'Презиме може да съдържа максимум 25 символа.',
            'surname.required' => 'Въведете фамилия.',
            'surname.min' => 'Фамилията трябва да съдържа минимум 3 символа.',
            'surname.max' => 'фамилията може да съдържа максимум 25 символа.',
            'egn.required' => 'Въведете ЕГН.',
            'egn.digits_between' => 'ЕГН трябва да съдържа 10 цифри.',
            'password.min' => 'Паролата трябва да съдържа минимум 6 символа.',
            'password.max' => 'Паролата не може съдържа повече от 8 символа.',
            'city_id.required' => 'Изберете град.',
            'email.required' => 'Въведете еmail.',
            'email' => 'Невалиден email.',
            'email.unique' => 'Грешен email.'
        ];
    }
}
