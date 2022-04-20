<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientInformationRequest;
use App\Http\Resources\PatientInformationResource;
use App\Models\PatientInformation;
use Illuminate\Support\Facades\Auth;

class CreatePatientInformationController
{
    public function __invoke(CreatePatientInformationRequest $request): PatientInformationResource
    {
        Auth::user()->can('create', PatientInformation::class);
        $patient = Auth::user()->patientInformation()->create($request->validated());

        return (new PatientInformationResource($patient))
            ->additional([
                'status' => 200,
                'message' => 'Information has been successfully created',
            ]);
    }
}
