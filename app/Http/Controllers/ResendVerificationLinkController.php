<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResendVerificationLinkController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status'=>200, 'message'=>'Verfication Link has been resended']);
    }
}
