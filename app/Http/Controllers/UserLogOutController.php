<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserLogOutController
{
    public function __invoke(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User logged out succesfully',
        ]);
    }
}
