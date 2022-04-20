<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPatientInformationRequest;
use App\Http\Resources\PatientInformationResource;
use App\Models\PatientInformation;
use Illuminate\Support\Facades\Auth;

class GetPatientInformationController extends Controller
{
    public function __invoke(GetPatientInformationRequest $request) : PatientInformationResource
    {
        Auth::user()->can('view', PatientInformation::class);

        return new PatientInformationResource(Auth::user()->patientInformation);
    }
}
