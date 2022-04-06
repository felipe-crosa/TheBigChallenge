<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return Auth::user()->hasRole('doctor');
    }

    public function rules():array
    {
        return [
            'speciality' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:50'],
            'institution' => ['required', 'max:50'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'institution' => ucwords($this['institution']),
            'speciality' => ucwords($this['speciality']),
        ]);
    }
}
