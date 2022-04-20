<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Submission::class);
    }

    public function rules(): array
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
