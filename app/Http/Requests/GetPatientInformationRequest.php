<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetPatientInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return isset(Auth::user()->patient_information);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
