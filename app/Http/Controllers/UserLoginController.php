<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserLoginController extends Controller
{
    public function __invoke(UserLoginRequest $request) : JsonResponse
    {
        $arguments = $request->validated();

        $user = User::where('email', $arguments['email'])->first();
        $response = [];
        if (isset($user)) {
            if ($user->password == $arguments['password']) {
                $response = [
                    'status'=>200,
                    'message'=>'User logged in succesfully',
                    'token'=>$user->createToken('app')->plainTextToken,
                ];
            } else {
                $response = ['status'=>401, 'message'=>'Invalid credentials'];
            }
        } else {
            $response = ['status'=>401, 'message'=>'Invalid credentials'];
        }

        return response()->json($response);
    }
}
