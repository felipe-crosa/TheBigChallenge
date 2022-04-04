<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request){
        $request->fulfill();
        return response()->json(['status'=>'200','message'=>'User has been verified successfully"']);
    }
}
