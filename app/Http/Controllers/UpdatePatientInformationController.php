<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientInformationRequest;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdatePatientInformationController extends Controller
{
    public function __invoke(UpdatePatientInformationRequest $request) : JsonResponse
    {
        Patient::where('user_id', Auth::id())->first()->update($request->validated());

        return response()->json(['status'=>200, 'message'=>'Information updated successfully']);
    }
}
