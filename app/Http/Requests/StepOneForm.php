<?php

namespace App\Http\Requests;

use App\Models\Declaration;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StepOneForm
 * @package App\Http\Requests
 */
class StepOneForm extends FormRequest
{
    private $declaration;

    public function __construct()
    {
        $this->declaration = Declaration::where('active', Declaration::ACTIVE)->first();
    }

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
        foreach ($this->declaration->questions as $key => $val) {
            if($val->type === 1) {
                $rules['answer.' . $val->id] = 'required|in:yes,no';
            }else{
                $rules['answer.' . $val->id] = 'required';
            }
        }
        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = [];
        foreach ($this->declaration->questions as $key => $val) {
            $messages['answer.' . $val->id . '.required'] = 'Моля отговорете на въпроса.';
            $messages['answer.' . $val->id . '.in'] = 'Невалиден отговор.';
        }
        return $messages;
    }
}
