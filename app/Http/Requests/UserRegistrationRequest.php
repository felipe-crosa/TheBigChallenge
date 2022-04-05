<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegistrationRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'name'=>'required | alpha | min:2 | max: 30',
            'email'=> ['required',  'email:strict', Rule::unique('users', 'email')],
            'password' => 'required | confirmed | min:7 | max: 25',
            'role'=>'required | exists:roles,name',
        ];
    }
}
