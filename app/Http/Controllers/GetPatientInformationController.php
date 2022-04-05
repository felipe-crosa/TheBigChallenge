<?php

namespace App\Http\Controllers;

use App\Http\Resources\PatientResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetPatientInformationController extends Controller
{
    public function __invoke() : JsonResponse
    {
        return response()->json((new PatientResource(Auth::user()->patient)));
    }
}
