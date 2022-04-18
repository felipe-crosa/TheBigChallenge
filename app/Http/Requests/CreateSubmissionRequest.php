<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSubmissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patient_id' =>['required', Rule::exists('patients', 'user_id')],
            'symptoms' => ['required'],
            'observations' => ['nullable'],
            'speciality' => 'required',
            'doctor_id' => ['nullable', Rule::exists('doctor_information', 'user_id')],
            'diagnostic' => ['nullable', 'file', 'mimes:txt'],
        ];
    }
}
