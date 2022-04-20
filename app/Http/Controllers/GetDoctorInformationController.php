<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetDoctorInformationRequest;
use App\Http\Resources\DoctorInformationResource;
use App\Models\DoctorInformation;
use Illuminate\Support\Facades\Auth;

class GetDoctorInformationController
{
    public function __invoke(GetDoctorInformationRequest $request): DoctorInformationResource
    {
        Auth::user()->can('view', DoctorInformation::class);

        return new DoctorInformationResource(Auth::user()->doctorInformation);
    }
}
