<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetDoctorInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return isset(Auth::user()->doctorInformation);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
