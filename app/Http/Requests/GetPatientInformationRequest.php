<?php

namespace App\Http\Requests;

use App\Models\PatientInformation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetPatientInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return  Auth::user()->can('view', PatientInformation::class);
    }

    public function rules(): array
    {
        return [];
    }
}
