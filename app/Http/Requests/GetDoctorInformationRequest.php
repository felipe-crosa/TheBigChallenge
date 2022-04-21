<?php

namespace App\Http\Requests;

use App\Models\DoctorInformation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetDoctorInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('view', DoctorInformation::class);
    }

    public function rules(): array
    {
        return [];
    }
}
