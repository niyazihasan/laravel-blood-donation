<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientForm
 * @package App\Http\Requests
 */
class PatientForm extends FormRequest
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
            'egn' => 'required|digits_between:10,10',
            'name' => 'required|min:3|max:25',
            'fathersname' => 'required|min:3|max:25',
            'surname' => 'required|min:3|max:25',
            'blood_type' => 'required',
            'blood_quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'egn.required' => 'Въведете ЕГН.',
            'egn.digits_between' => 'ЕГН трябва да съдържа 10 цифри.',
            'count_blood_quantity.integer' => 'Въведете брой намерени донори.',
            'blood_quantity.min' => 'Въведете брой донори.',
            'blood_quantity.integer' => 'Въведете брой донори.',
            'blood_quantity.required' => 'Въведете брой донори.',
            'name.required' => 'Въведете име.',
            'name.min' => 'Името трябва да съдържа минимум 3 символа.',
            'name.max' => 'Името може да съдържа максимум 25 символа.',
            'fathersname.required' => 'Въведете презиме.',
            'fathersname.min' => 'Презиме трябва да съдържа минимум 3 символа.',
            'fathersname.max' => 'Презиме може да съдържа максимум 25 символа.',
            'surname.required' => 'Въведете фамилия.',
            'surname.min' => 'Фамилията трябва да съдържа минимум 3 символа.',
            'surname.max' => 'фамилията може да съдържа максимум 25 символа.',
            'blood_type.required' => 'Изберете кръвна група.',
        ];
    }
}
