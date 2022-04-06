<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetDoctorInformationRequest;
use App\Http\Resources\DoctorInformationResource;
use Illuminate\Support\Facades\Auth;

class GetDoctorInformationController extends Controller
{
    public function __invoke(GetDoctorInformationRequest $request): DoctorInformationResource
    {
        return new DoctorInformationResource(Auth::user()->doctorInformation);
    }
}
