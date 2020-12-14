<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepTwoForm extends FormRequest
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
        $rules = [];
        if ($this->request->get('flag') === 'yes') {
            if ($this->request->get('patient')) {
                $rules['search'] = 'in';
            }
        } else if ($this->request->get('flag') === 'no') {
            $rules['search'] = 'required';
        } else {
            $rules['flag'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'search.in' => 'Изчистете полето за пациент и натиснете дарете кръв.',
            'search.required' => 'Изберете донор.',
            'flag.required' => 'Изберете да или не.'
        ];
    }
}
