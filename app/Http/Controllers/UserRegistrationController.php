<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserRegistrationController extends Controller
{
    public function __invoke(UserRegistrationRequest $request): JsonResponse
    {
        $arguments = $request->validated();
        $arguments['password'] = Hash::make($request['password']);

        $user = User::create($arguments);
        $user->assignRole($arguments['role']);

        $response = [
            'status' => 200,
            'message' => 'User has been added succesfully',
        ];

        ($arguments['role'] == 'patient') ? Patient::create(['user_id' => $user->id]) : false /* Here goes the creation of doctor*/;

        return response()->json($response);
    }
}
