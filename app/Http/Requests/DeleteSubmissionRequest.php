<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
}
