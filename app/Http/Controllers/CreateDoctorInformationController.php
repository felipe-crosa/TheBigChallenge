<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctorInformationRequest;
use App\Http\Resources\DoctorInformationResource;
use App\Models\DoctorInformation;
use Illuminate\Support\Facades\Auth;

class CreateDoctorInformationController
{
    public function __invoke(CreateDoctorInformationRequest $request): DoctorInformationResource
    {
        Auth::user()->can('create', DoctorInformation::class);

        $doctorInformation = Auth::user()->doctorInformation()->create($request->validated());

        return (new DoctorInformationResource($doctorInformation))
            ->additional([
                'status' => 200,
                'message' => 'Information created successfully',
            ]);
    }
}
