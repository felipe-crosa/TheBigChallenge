<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreatePatientInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->hasRole('patient') && ! isset(Auth::user()->patientInformation);
    }

    public function rules(): array
    {
        return [
            'height' => ['required', 'numeric', 'between:30,240'],
            'weight' => ['required', 'numeric', 'between:3,1000'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'date_of_birth' => ['required', 'before:today'],
            'medical_conditions' => ['max:255'],
            'allergies' => ['max:255'],
        ];
    }
}
