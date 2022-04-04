<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientInformationRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'height'=>'required|numeric|between:30,240',
            'weight'=>'required|numeric|between:3,1000',
            'gender'=>['required', Rule::in(['male', 'female'])],
            'date of birth'=>'required|before:today',
            'medical conditions'=>'max:255',
            'allergies'=>'max:255',
        ];
    }
}
