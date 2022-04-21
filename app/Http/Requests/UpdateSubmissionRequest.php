<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'symptoms' => ['required'],
            'observations' => ['nullable'],
            'speciality' => 'required',
        ];
    }
}
