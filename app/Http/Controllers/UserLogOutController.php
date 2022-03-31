<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserLogOutController extends Controller
{
    public function __invoke()
    {
        Auth::user()->tokens()->delete();
    }
}
