<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserRegistrationController extends Controller
{
    public function __invoke(UserRegistrationRequest $request) : JsonResponse
    {
        User::create($request->validated());

        $response = [
            'status'=>200,
            'message'=>'User has been added succesfully',
        ];

        return response()->json($response);
    }
}
