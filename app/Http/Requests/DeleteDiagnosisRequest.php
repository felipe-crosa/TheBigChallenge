<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteDiagnosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('submission');

        return Auth::user()->can('deleteDiagnosis', $submission);
    }

    public function rules(): array
    {
        return [
            'diagnosisFileName' => ['required', 'string'],
        ];
    }
}
