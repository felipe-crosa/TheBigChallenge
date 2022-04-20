<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientInformationRequest;
use App\Http\Resources\PatientInformationResource;
use App\Models\PatientInformation;
use Illuminate\Support\Facades\Auth;

class UpdatePatientInformationController
{
    public function __invoke(UpdatePatientInformationRequest $request) : PatientInformationResource
    {
        Auth::user()->can('update', PatientInformation::class);
        $patient = PatientInformation::where('user_id', Auth::id())->first();
        $patient->update($request->validated());

        return (new PatientInformationResource($patient))
            ->additional([
                'status' => 200,
                'message' => 'Information updated successfully',
            ]);
    }
}
