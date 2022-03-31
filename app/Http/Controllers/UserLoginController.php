<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserLoginController extends Controller
{
    public function __invoke(UserLoginRequest $request): UserResource|JsonResponse
    {
        $arguments = $request->validated();

        $user = User::where('email', $arguments['email'])->first();

        if ($user && Hash::check($arguments['password'], $user->password)) {
            return (new UserResource($user))
                ->additional([
                    'status' => 200,
                    'message' => 'User logged in succesfully',
                    'token' => $user->createToken('app')->plainTextToken,
                ]);
        }

        $response = ['status' => 401, 'message' => 'Invalid credentials'];

        return response()->json($response);
    }
}
