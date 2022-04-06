<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPatientInformationRequest;
use App\Http\Resources\PatientInformationResource;
use Illuminate\Support\Facades\Auth;

class GetPatientInformationController extends Controller
{
    public function __invoke(GetPatientInformationRequest $request) : PatientInformationResource
    {
        return new PatientInformationResource(Auth::user()->patientInformation);
    }
}
