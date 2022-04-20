<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResendVerificationLinkController
{
    public function __invoke(Request $request) : JsonResponse
    {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status'=>200, 'message'=>'Verfication Link has been resended']);
    }
}
